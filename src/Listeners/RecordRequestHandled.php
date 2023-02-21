<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled;

class RecordRequestHandled
{
    public function handle(RequestHandled $event): void
    {
        // Run an actions pipeline to collect and format request data
    }
}
