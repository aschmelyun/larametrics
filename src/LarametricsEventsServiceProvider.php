<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Routing\Events\RouteMatched;
use Aschmelyun\Larametrics\Listeners\LogListener;
use Aschmelyun\Larametrics\Listeners\RouteListener;
use Aschmelyun\Larametrics\Observers\ModelObserver;

class LarametricsEventsServiceProvider extends EventServiceProvider
{

    protected $listen = [
        MessageLogged::class => [
            LogListener::class
        ],
        RouteMatched::class => [
            RouteListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        if(!config('larametrics')) {
            return;
        }

        foreach(config('larametrics.modelsWatched') as $model) {
            try {
                $model::observe(new ModelObserver());
            } catch(\Exception $e) {}
        }
    }

}