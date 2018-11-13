<?php

namespace Aschmelyun\Larametrics\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Aschmelyun\Larametrics\Models\LarametricsRequest;

class RouteRequested extends Notification implements ShouldQueue
{
    use Queueable;

    private $larametricsRequest;

    private $requestInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LarametricsRequest $larametricsRequest)
    {
        $this->larametricsRequest = $larametricsRequest;

        $this->requestInfo = array(
            'id' => $larametricsRequest->id,
            'method' => $larametricsRequest->method,
            'uri' => $larametricsRequest->uri,
            'ip' => $larametricsRequest->ip,
            'execution_time' => floor(($larametricsRequest->end_time - $larametricsRequest->start_time) * 1000)
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        switch($notifiable->notify_by) {
            case 'email':
                return ['mail'];
            break;
            case 'slack':
                return ['slack'];
            break;
            case 'email_slack':
                return ['mail', 'slack'];
            break;
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $content = 'A route on ' . url('/') . ' was requested.';
        if($notifiable->filter !== '*' && !is_numeric($notifiable->filter)) {
            $content .= " You're being notified because the route contains `" . $notifiable->filter . "`";
        }

        if(is_numeric($notifiable->filter)) {
            $content .= " You're being notified because the execution time exceeded your limit of " . $notifiable->filter . "ms.";
        }

        $alertColor = '#00B945';
        if(is_numeric($notifiable->filter) && $this->requestInfo['execution_time'] > intval($notifiable->filter)) {
            $alertColor = '#BC001A';
        }

        return (new MailMessage)
            ->subject(env('LARAMETRICS_ROUTE_SUBJECT', '[Larametrics Alert] A route has been requested'))
            ->from(env('LARAMETRICS_FROM_EMAIL', 'alerts@larametrics.com'), env('LARAMETRICS_FROM_NAME', 'Larametrics Alerts'))
            ->view('larametrics::emails.route-requested', [
                'requestInfo' => $this->requestInfo,
                'content' => $content,
                'alertColor' => $alertColor
            ]);
    }

    public function toSlack($notifiable)
    {
        $content = 'A route on ' . url('/') . ' was requested.';
        if($notifiable->filter !== '*' && !is_numeric($notifiable->filter)) {
            $content .= " You're being notified because the route contains `" . $notifiable->filter . "`";
        }

        if(is_numeric($notifiable->filter)) {
            $content .= " You're being notified because the execution time exceeded your limit of " . $notifiable->filter . "ms.";
        }

        $status = 'success';
        if(is_numeric($notifiable->filter) && $this->requestInfo['execution_time'] > intval($notifiable->filter)) {
            $status = 'error';
        }

        $requestInfo = $this->requestInfo;

        return (new SlackMessage)
            ->{ $status }()
            ->attachment(function($attachment) use($requestInfo, $content) {
                $attachment->title('Request #' . $requestInfo['id'], route('larametrics::requests.show', $requestInfo['id']))
                    ->content($content)
                    ->fields([
                        'Method' => $requestInfo['method'],
                        'From IP' => $requestInfo['ip'],
                        'Requested URI' => $requestInfo['uri'],
                        'Execution Time' => $requestInfo['execution_time'] . 'ms'
                    ]);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
