<?php

namespace Aschmelyun\Larametrics\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Aschmelyun\Larametrics\Models\LarametricsModel;

class ModelChanged extends Notification implements ShouldQueue
{
    use Queueable;

    private $larametricsModel;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LarametricsModel $larametricsModel)
    {
        $this->larametricsModel = $larametricsModel;
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
        $modelInfo = array(
            'id' => $this->larametricsModel->id,
            'model' => $this->larametricsModel->model,
            'method' => $this->larametricsModel->method,
            'original' => json_decode($this->larametricsModel->original, true),
            'changes' => json_decode($this->larametricsModel->changes, true)
        );
        $alertColor = '#ff9f00';
        switch($this->larametricsModel->method) {
            case 'created':
                $alertColor = '#00B945';
            break;
            case 'deleted':
                $alertColor = '#BC001A';
            break;
        }

        return (new MailMessage)
            ->subject(env('LARAMETRICS_MODEL_SUBJECT', '[Larametrics Alert] A model has been ' . $modelInfo['method']))
            ->from(env('LARAMETRICS_FROM_EMAIL', 'alerts@larametrics.com'), env('LARAMETRICS_FROM_NAME', 'Larametrics Alerts'))
            ->view('larametrics::emails.model-changed', [
                'modelInfo' => $modelInfo,
                'alertColor' => $alertColor
            ]);
    }

    public function toSlack($notifiable)
    {
        $modelInfo = array(
            'id' => $this->larametricsModel->id,
            'model' => $this->larametricsModel->model,
            'original' => json_decode($this->larametricsModel->original, true),
            'changes' => json_decode($this->larametricsModel->changes, true)
        );
        
        switch($this->larametricsModel->method) {
            case 'updated':
                return (new SlackMessage)
                    ->warning()
                    ->attachment(function($attachment) use($modelInfo) {
                        $columnsChanged = '';
                        foreach(array_keys($modelInfo['changes']) as $changedColumn) {
                            $columnsChanged .= '    • ' . $changedColumn . "\r\n";
                        }
                        $attachment->title($modelInfo['model'] . ' #' . $modelInfo['original']['id'], route('larametrics::models.show', $modelInfo['id']))
                            ->content('A model on ' . url('/') . ' has been updated. The following columns have changed:' . "\r\n" . $columnsChanged)
                            ->markdown(['text']);
                    });
            break;
            case 'created':
                    return (new SlackMessage)
                        ->success()
                        ->attachment(function($attachment) use($modelInfo) {
                            $attachment->title($modelInfo['model'] . ' #' . $modelInfo['original']['id'], route('larametrics::models.show', $modelInfo['id']))
                                ->content('A model on ' . url('/') . ' has been created.');
                        });
            break;
            case 'deleted':
                    return (new SlackMessage)
                        ->error()
                        ->attachment(function($attachment) use($modelInfo) {
                            $attachment->title($modelInfo['model'] . ' #' . $modelInfo['original']['id'], route('larametrics::models.show', $modelInfo['id']))
                                ->content('A model on ' . url('/') . ' has been deleted.');
                        });
            break;
        }
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
