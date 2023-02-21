<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Providers;

use Aschmelyun\Larametrics\Events\ModelChanged;
use Aschmelyun\Larametrics\Listeners\RecordModelChanged;
use Aschmelyun\Larametrics\Listeners\RecordRequestHandled;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

class EventServiceProvider extends LaravelEventServiceProvider
{
    protected $listen = [
        RequestHandled::class => [
            RecordRequestHandled::class,
        ],
        ModelChanged::class => [
            RecordModelChanged::class,
        ],
    ];
}
