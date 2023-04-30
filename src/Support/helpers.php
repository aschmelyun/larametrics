<?php declare(strict_types=1);

if (! function_exists('larametric')) {
    function larametric(string $name, mixed $data = null): void
    {
        event(new \Aschmelyun\Larametrics\Events\DefinedEvent($name, $data));
    }
}

if (! function_exists('bar_width')) {
    function bar_width(int $value, int $total, int $max = 100): float
    {
        return round(($value / $total) * $max);
    }
}
