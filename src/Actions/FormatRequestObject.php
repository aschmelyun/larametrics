<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;

class FormatRequestObject implements Action
{
    /**
     * @param  array<mixed>  $event
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        $request = [
            'method' => $event['request']->method(),
            'url' => $event['request']->fullUrl(),
            'path' => '/'.$event['request']->path(),
            'ip' => $event['request']->ip(),
            'user_agent' => $event['request']->userAgent(),
            'input' => $event['request']->input(),
            'session' => $event['request']->session ? $event['request']->session()->all() : null,
            'route' => $event['route'],
            'user' => $event['user'],
            'is_unique' => $event['is_unique'],
            'response_code' => $event['response']->getStatusCode(),
        ];

        return $next($request);
    }
}
