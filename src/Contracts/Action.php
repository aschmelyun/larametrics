<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Contracts;

interface Action
{
    /**
     * @param  array<mixed>  $event
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array;
}
