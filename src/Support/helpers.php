<?php declare(strict_types=1);

if (! function_exists('larametric')) {
    function larametric(string $name, mixed $data = null): void
    {
        event(new \Aschmelyun\Larametrics\Events\DefinedEvent($name, $data));
    }
}