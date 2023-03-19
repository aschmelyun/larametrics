<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;

class AttachRequestToEvent implements Action
{
    /**
     * @param  array<mixed>  $event
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        return $next($event);
    }
}