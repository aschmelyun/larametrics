<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Log\Events\MessageLogged;
use Aschmelyun\Larametrics\Models\LarametricsLog;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Notifications\LogWritten;

class LarametricsLogServiceProvider extends ServiceProvider {

    public function boot()
    {
        Event::listen(MessageLogged::class, function(MessageLogged $e) {
            if (config('larametrics.logsWatched') === true) {
                try {
                    $larametricsLog = LarametricsLog::create([
                        'level' => $e->level,
                        'message' => $e->message,
                        'user_id' => count($e->context) ? $e->context['userId'] : null,
                        'email' => count($e->context) ? $e->context['email'] : null,
                        'trace' => count($e->context) ? json_encode($e->context['exception']->getTrace()) : '[]'
                    ]);

                    $logLevel = 'notice';
                    $notificationLevels = array(
                        'error' => [
                            'emergency',
                            'alert',
                            'critical',
                            'error'
                        ],
                        'notice' => [
                            'warning',
                            'notice'
                        ],
                        'debug' => [
                            'info',
                            'debug'
                        ]
                    );

                    foreach($notificationLevels as $triggerLevel => $childLevels) {
                        if(in_array($e->level, $childLevels)) {
                            $logLevel = $triggerLevel;
                        }
                    }

                    $notifications = LarametricsNotification::where('action', 'logged_' . $logLevel)
                        ->get();

                    foreach($notifications as $index => $notification) {
                        if($notification->filter !== '*' && !str_contains($e->message, $notification->filter)) {
                            unset($notifications[$index]);
                        }
                    }

                    if(count($notifications)) {
                        foreach($notifications as $notification) {
                            Notification::send($notification, new LogWritten($larametricsLog));
                        }
                    }

                } catch(\Exception $e) {
                    // fail silently
                }
            }
        });
    }

}
