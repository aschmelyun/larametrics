<?php

namespace Aschmelyun\Larametrics\Actions;

use Illuminate\Http\Request;
use Illuminate\Routing\Events\RouteMatched;
use Aschmelyun\Larametrics\Models\LarametricsRequest;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Notifications\RouteRequested;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SaveRoute
{

    private $route;
    private $request;

    public function __construct(RouteMatched $route, Request $request)
    {
        $this->route = $route;
        $this->request = $request;
    }

    public function dispatch()
    {
        app()->terminating($this->dispatchAfterTerminating());
    }

    public function dispatchAfterTerminating()
    {
        if(!$this->shouldRequestBeStored()) {
            return false;
        }

        $this->checkExpiredLogs();

        $createdRoute = $this->createRoute();
        if($createdRoute) {
            $this->triggerNotifications($createdRoute);
        }

        return true;
    }

    public function shouldRequestBeStored()
    {
        $actions = $this->route->route->getAction();

        if (isset($actions['controller']) && \Str::contains($actions['controller'], 'Larametrics')) {
            if (config('larametrics.ignoreLarametricsRequests')) {
                return false;
            }
        }

        if (!empty(config('larametrics.requestsToSkip'))) {
            $req = Request::createFromGlobals();
            foreach(config('larametrics.requestsToSkip') as $pathToSkip) {
                if ($req->is($pathToSkip)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function checkExpiredLogs()
    {
        if (config('larametrics.requestsWatchedExpireDays') !== 0) {
            LarametricsRequest::where('created_at', '<', Carbon::now()->subDays(config('larametrics.requestsWatchedExpireDays'))->toDateTimeString())
                ->delete();
        }

        if (config('larametrics.requestsWatchedExpireAmount') !== 0) {
            $expiredModels = LarametricsRequest::orderBy('created_at', 'desc')
                ->offset(config('larametrics.requestsWatchedExpireAmount'))
                ->limit(config('larametrics.requestsWatchedExpireAmount'))
                ->pluck('id')
                ->toArray();

            LarametricsRequest::destroy($expiredModels);
        }
    }

    public function createRoute()
    {
        try {
            return LarametricsRequest::create([
                'method' => $this->route->request->getMethod(),
                'uri' => $this->route->request->getRequestUri(),
                'ip' => $this->route->request->ip(),
                'headers' => json_encode($this->route->request->header()),
                'start_time' => LARAVEL_START,
                'end_time' => microtime(true)
            ]);
        } catch(\Exception $e) {
            return null;
        }
    }

    public function triggerNotifications(LarametricsRequest $request)
    {
        $notifications = LarametricsNotification::whereIn('action', ['request_route', 'execution_time'])
            ->get();

        foreach($notifications as $index => $notification) {
            if($notification->action === 'execution_time') {
                $executionTime = floor(($request->end_time - $request->start_time) * 1000);
                if($executionTime <= intval($notification->filter)) {
                    unset($notifications[$index]);
                }
            } else {
                if($notification->filter !== '*' && !\Str::contains($request->uri, $notification->filter)) {
                    unset($notifications[$index]);
                }
            }
        }

        if(count($notifications)) {
            foreach($notifications as $notification) {
                Notification::send($notification, new RouteRequested($request));
            }
        }
    }
}