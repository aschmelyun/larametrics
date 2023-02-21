<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Providers;

use Aschmelyun\Larametrics\Events\ModelChanged;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

class EventServiceProvider extends LaravelEventServiceProvider
{
    protected $listen = [
        RequestHandled::class => [
            'Aschmelyun\Larametrics\Listeners\RequestHandled',
        ],
        ModelChanged::class => [
            'Aschmelyun\Larametrics\Listeners\ModelChanged',
        ],
    ];
}
