<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;

class GetRouteFromRequest implements Action
{
    /**
     * @param  array<mixed>  $event
     * @param  \Closure  $next
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        if (! $event['request']->route()) {
            $event['route'] = null;

            return $next($event);
        }

        $event['route'] = [
            'name' => $event['request']->route()->getName(),
            'uri' => $event['request']->route()->uri(),
            'uses' => $event['request']->route()->getAction('uses'),
        ];

        return $next($event);
    }
}
