<?php

namespace Aschmelyun\Larametrics\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;
use Illuminate\Foundation\Http\Events\RequestHandled;

class EventServiceProvider extends LaravelEventServiceProvider
{
    protected $listen = [
        RequestHandled::class => [
            'Aschmelyun\Larametrics\Listeners\RequestHandled'
        ]
    ];
}
