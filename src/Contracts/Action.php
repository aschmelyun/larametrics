<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Contracts;

interface Action
{
    /**
     * @param  array<mixed>  $event
     * @param  \Closure  $next
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array;
}
