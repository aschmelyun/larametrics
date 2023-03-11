<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;
use Illuminate\Http\Request;

class DetermineUniquenessOfVisit implements Action
{
    /**
     * @param  array<mixed>  $event
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        $event['is_unique'] = true;

        if (config('larametrics.unique_visits')) {
            $event['is_unique'] = $this->isUniqueVisit($event['request']);
        }

        return $next($event);
    }

    private function isUniqueVisit(Request $request): bool
    {
        // Determine unique visits by IP address and user agent
        return true;
    }
}
