<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Log\Events\MessageLogged;
use Aschmelyun\Larametrics\Listeners\LogListener;
use Aschmelyun\Larametrics\Listeners\ModelListener;
use Aschmelyun\Larametrics\Listeners\RouteListener;
use Aschmelyun\Larametrics\Observers\ModelObserver;

class LarametricsEventsServiceProvider extends EventServiceProvider
{

    protected $listen = [
        MessageLogged::class => [
            LogListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        foreach(config('larametrics.modelsWatched') as $model) {
            try {
                $model::observe(new ModelObserver());
            } catch(\Exception $e) {}
        }
        // foreach of the config file's models to watch, call $model::observer(new ModelObserver())
        // the class of the ModelObserver contains two methods, one for saving and one for deleting
        // would the same event object pull through though?
    }

}