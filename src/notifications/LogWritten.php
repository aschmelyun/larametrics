<?php

namespace Aschmelyun\Larametrics\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Aschmelyun\Larametrics\Models\LarametricsLog;

class LogWritten extends Notification implements ShouldQueue
{
    use Queueable;

    private $larametricsLog;

    private $requestInfo;

    private $notificationLevels;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LarametricsLog $larametricsLog)
    {
        $this->larametricsLog = $larametricsLog;

        $this->requestInfo = array(
            'id' => $larametricsLog->id,
            'level' => $larametricsLog->level,
            'message' => $larametricsLog->message,
            'user_id' => $larametricsLog->user_id ? $larametricsLog->user_id : null,
            'email' => $larametricsLog->email ? $larametricsLog->email : null
        );

        $this->notificationLevels = array(
            'error' => [
                'emergency',
                'alert',
                'critical',
                'error'
            ],
            'warning' => [
                'warning',
                'notice'
            ],
            'success' => [
                'info',
                'debug'
            ]
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
        $content = 'A log on ' . url('/') . ' has been written to.';
        if($notifiable->filter !== '*') {
            $content .= " You're being notified because the log contains `" . $notifiable->filter . "`";
        }

        $status = 'success';
        foreach($this->notificationLevels as $triggerLevel => $childLevels) {
            if(in_array($this->requestInfo['level'], $childLevels)) {
                $status = $triggerLevel;
            }
        }

        $fields = array(
            'Level' => $this->requestInfo['level'],
            'Message' => $this->requestInfo['message']
        );

        if($this->requestInfo['user_id']) {
            $fields['User ID'] = $this->requestInfo['user_id'];
        }

        if($this->requestInfo['email']) {
            $fields['Associated Email'] = $this->requestInfo['email'];
        }

        $statusColors = array(
            'success' => '#00B945',
            'warning' => '#ff9f00',
            'error' => '#BC001A'
        );

        return (new MailMessage)
            ->subject(env('LARAMETRICS_LOG_SUBJECT', '[Larametrics Alert] The application log has been written to'))
            ->from(env('LARAMETRICS_FROM_EMAIL', 'alerts@larametrics.com'), env('LARAMETRICS_FROM_NAME', 'Larametrics Alerts'))
            ->view('larametrics::emails.log-written', [
                'requestInfo' => $this->requestInfo,
                'content' => $content,
                'alertColor' => $statusColors[$status]
            ]);
    }

    public function toSlack($notifiable)
    {
        $content = 'A log on ' . url('/') . ' has been written to.';
        if($notifiable->filter !== '*') {
            $content .= " You're being notified because the log contains `" . $notifiable->filter . "`";
        }

        $status = 'success';
        foreach($this->notificationLevels as $triggerLevel => $childLevels) {
            if(in_array($this->requestInfo['level'], $childLevels)) {
                $status = $triggerLevel;
            }
        }

        $fields = array(
            'Level' => $this->requestInfo['level'],
            'Message' => $this->requestInfo['message']
        );

        if($this->requestInfo['user_id']) {
            $fields['User ID'] = $this->requestInfo['user_id'];
        }

        if($this->requestInfo['email']) {
            $fields['Associated Email'] = $this->requestInfo['email'];
        }

        $requestInfo = $this->requestInfo;

        return (new SlackMessage)
            ->{ $status }()
            ->attachment(function($attachment) use($requestInfo, $fields, $content) {
                $attachment->title('Log #' . $requestInfo['id'], route('larametrics::logs.show', $requestInfo['id']))
                    ->content($content)
                    ->fields($fields);
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
