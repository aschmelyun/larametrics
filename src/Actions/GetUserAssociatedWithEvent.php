<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;

class GetUserAssociatedWithEvent implements Action
{
    /**
     * @param  array<mixed>  $event
     * @param  \Closure  $next
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        $event['user'] = null;

        if (auth()->check()) {
            $event['user'] = auth()->user();
        }

        return $next($event);
    }
}
