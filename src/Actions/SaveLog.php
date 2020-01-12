<?php

namespace Aschmelyun\Larametrics\Actions;

use Illuminate\Http\Request;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Notification;
use Aschmelyun\Larametrics\Models\LarametricsLog;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Notifications\LogWritten;
use Carbon\Carbon;

class SaveLog
{

    private $message;
    private $request;

    public function __construct(MessageLogged $message, Request $request)
    {
        $this->message = $message;
        $this->request = $request;
    }

    public function dispatch()
    {
        $this->checkExpiredLogs();

        $createdLog = $this->createLog();
        if($createdLog) {
            $this->triggerNotifications($createdLog);
        }

        return $createdLog;
    }
    
    public function checkExpiredLogs()
    {
        if(config('larametrics.logsWatchedExpireDays') !== 0) {
            LarametricsLog::where('created_at', '<', Carbon::now()->subDays(config('larametrics.logsWatchedExpireDays'))->toDateTimeString())
                ->delete();
        }

        if(config('larametrics.logsWatchedExpireAmount') !== 0) {
            $expiredLogs = LarametricsLog::orderBy('created_at', 'desc')
                ->offset(config('larametrics.logsWatchedExpireAmount'))
                ->limit(config('larametrics.logsWatchedExpireAmount'))
                ->pluck('id')
                ->toArray();
            LarametricsLog::destroy($expiredLogs);
        }
    }
    
    public function createLog()
    {
        if (config('larametrics.logsWatched')) {
            try {
                return LarametricsLog::create([
                    'level' => $this->message->level,
                    'message' => $this->message->message,
                    'user_id' => isset($this->message->context['userId']) ? $this->message->context['userId'] : null,
                    'email' => isset($this->message->context['email']) ? $this->message->context['email'] : null,
                    'trace' => isset($this->message->context['exception']) ? json_encode($this->message->context['exception']->getTrace()) : '[]'
                ]);
            } catch(\Exception $e) {
                return null;
            }
        }

        return null;
    }

    public function triggerNotifications(LarametricsLog $log)
    {
        $notifications = LarametricsNotification::where('action', 'logged_' . $log->log_level)
            ->get();

        foreach($notifications as $index => $notification) {
            if ($notification->filter !== '*' && !str_contains($this->message->message, $notification->filter)) {
                unset($notifications[$index]);
            }
        }

        if(count($notifications)) {
            foreach($notifications as $notification) {
                try {
                    Notification::send($notification, new LogWritten($log));
                } catch(\Exception $e) {}
            }
        }
    }

}