<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Log\Events\MessageLogged;
use Aschmelyun\Larametrics\Listeners\LogListener;
use Aschmelyun\Larametrics\Listeners\ModelListener;
use Aschmelyun\Larametrics\Listeners\RouteListener;

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
    }

}