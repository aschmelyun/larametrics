<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled as LaravelRequestHandled;

class RequestHandled
{
    public function handle(LaravelRequestHandled $event): void
    {
        // Run an actions pipeline to collect and format request data
    }
}
