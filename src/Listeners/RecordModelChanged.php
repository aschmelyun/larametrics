<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Events\ModelChanged;

class RecordModelChanged
{
    public function handle(ModelChanged $event): void
    {
        // Run an actions pipeline to collect and format model change data
    }
}
