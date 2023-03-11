<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Actions\DetermineUniquenessOfVisit;
use Aschmelyun\Larametrics\Actions\FormatRequestObject;
use Aschmelyun\Larametrics\Actions\GetRouteFromRequest;
use Aschmelyun\Larametrics\Actions\GetUserAssociatedWithEvent;
use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Pipeline\Pipeline;

class RecordRequestHandled
{
    public function handle(RequestHandled $event): void
    {
        // If the request is ignored, return
        if ($this->shouldRouteBeIgnored($event)) {
            return;
        }

        // Run an actions pipeline to collect and format request data
        $request = app(Pipeline::class)
            ->send([
                'request' => $event->request,
                'response' => $event->response,
            ])
            ->through([
                GetRouteFromRequest::class,
                GetUserAssociatedWithEvent::class,
                DetermineUniquenessOfVisit::class,
                FormatRequestObject::class,
            ])
            ->thenReturn();

        // Save the request to the database
        LarametricsEvent::create([
            'user_id' => $request['user'] ? $request['user']->id : null,
            'type' => 'request',
            'data' => $request,
        ]);
    }

    private function shouldRouteBeIgnored(RequestHandled $event): bool
    {
        if (! config('larametrics.ignore_request_routes')) {
            return false;
        }

        if (! is_array(config('larametrics.ignore_request_routes'))) {
            return false;
        }

        foreach (config('larametrics.ignore_request_routes') as $route) {
            // If the route is a wildcard, check if the request path contains the route
            if (substr($route, -1) === '*') {
                if (str_contains($event->request->path(), substr($route, 0, -1))) {
                    return true;
                }
            }

            // If the route is not a wildcard, check if the request path matches the route
            if ($event->request->path() === $route) {
                return true;
            }
        }

        return false;
    }
}
