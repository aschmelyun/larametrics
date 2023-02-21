<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Events\ModelChanged as EventModelChanged;

class ModelChanged
{
    public function handle(EventModelChanged $event): void
    {
        // Run an actions pipeline to collect and format model change data
    }
}
