<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Events;

class DefinedEvent
{
    public function __construct(
        public string $name,
        public mixed $data,
    ) {
    }
}
