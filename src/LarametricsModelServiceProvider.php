<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Aschmelyun\Larametrics\Models\LarametricsModel;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Notifications\ModelChanged;
use Carbon\Carbon;

class LarametricsModelServiceProvider extends ServiceProvider {

    public function boot()
    {
        $eventListeners = [];

        if(!config('larametrics.modelsWatched')) {
            return;
        }
        
        foreach(config('larametrics.modelsWatched') as $model) {
            array_push($eventListeners,
                'eloquent.saved: ' . $model,
                //'eloquent.created: ' . $model,
                'eloquent.deleted: ' . $model
            );
        }

        Event::listen($eventListeners, function($event) {
            //dd(get_class($event));
            //dd($event);

            $method = 'updated';
            if(!$event->exists) {
                $method = 'deleted';
            } else if($event->wasRecentlyCreated) {
                $method = 'created';
            }

            if(config('larametrics.modelsWatchedExpireDays') !== 0) {
                $expiredModels = LarametricsModel::where('created_at', '<', Carbon::now()->subDays(config('larametrics.modelsWatchedExpireDays'))->toDateTimeString())
                    ->delete();
            }
            
            if(config('larametrics.modelsWatchedExpireAmount') !== 0) {
                $expiredModels = LarametricsModel::orderBy('created_at', 'desc')
                    ->offset(config('larametrics.modelsWatchedExpireAmount'))
                    ->limit(config('larametrics.modelsWatchedExpireAmount'))
                    ->pluck('id')
                    ->toArray();

                LarametricsModel::destroy($expiredModels);
            }

            $larametricsModel = LarametricsModel::create([
                'model' => get_class($event),
                'model_id' => $event->getKey(),
                'method' => $method,
                'original' => $method === 'created' ? json_encode($event->getAttributes()) : json_encode($event->getOriginal()),
                'changes' => $method === 'updated' ? json_encode($event->getDirty()) : '{}'
            ]);

            $notifications = LarametricsNotification::where('action', 'model_' . $method)
                ->get();

            foreach($notifications as $index => $notification) {
                if($notification->filter !== '*' && $notification->filter != get_class($event)) {
                    unset($notifications[$index]);
                }
            }

            if(count($notifications)) {
                foreach($notifications as $notification) {
                    Notification::send($notification, new ModelChanged($larametricsModel));
                }
            }
        });
    }

    public function register()
    {
        
    }

}
