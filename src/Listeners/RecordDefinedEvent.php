<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Events\DefinedEvent;

class RecordDefinedEvent
{
    public function handle(DefinedEvent $event): void
    {
        // Run an actions pipeline to collect and format user-defined event data
    }
}
