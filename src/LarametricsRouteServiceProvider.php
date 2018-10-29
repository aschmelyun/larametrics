<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Models\LarametricsRequest;
use Aschmelyun\Larametrics\Notifications\RouteRequested;
use Carbon\Carbon;

class LarametricsRouteServiceProvider extends ServiceProvider {

    public function boot()
    {
        if(config('larametrics.requestsWatched')) {
            Route::matched(function($routeMatched) {
                //dd($routeMatched);
                //echo 'Laravel started: ' . LARAVEL_START;
                //echo 'Route matched: ' . microtime(true);
                
                $done = false;
                $this->app->terminating(function () use($routeMatched, $done) {
                    //$executionTime = floor((microtime(true) - LARAVEL_START) * 1000);
                    //echo 'Execution time: ' . $executionTime . 'ms';
                    //echo 'Terminating: ' . microtime(true);

                    $shouldAddRequest = true;
                    $actions = $routeMatched->route->action;
                    if(isset($actions['controller']) && str_contains($actions['controller'], 'Larametrics')) {
                        if(config('larametrics.ignoreLarametricsRequests')) {
                            $shouldAddRequest = false;
                        }
                    }

                    if(config('larametrics.requestsWatchedExpireDays') !== '0') {
                        $expiredModels = LarametricsRequest::where('created_at', '<', Carbon::now()->subDays(config('larametrics.requestsWatchedExpireDays'))->toDateTimeString())
                            ->delete(); 
                    }

                    if(config('larametrics.requestsWatchedExpireAmount') !== '0') {
                        $expiredModels = LarametricsRequest::orderBy('created_at', 'desc')
                            ->offset(config('larametrics.requestsWatchedExpireAmount'))
                            ->limit(config('larametrics.requestsWatchedExpireAmount'))
                            ->pluck('id')
                            ->toArray();

                        LarametricsRequest::destroy($expiredModels);
                    }

                    if(!$done && $shouldAddRequest) {
                        $larametricsRequest = LarametricsRequest::create([
                            'method' => $routeMatched->request->getMethod(),
                            'uri' => $routeMatched->request->getRequestUri(),
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'headers' => json_encode($routeMatched->request->header()),
                            'start_time' => LARAVEL_START,
                            'end_time' => microtime(true),
                            'user_id' => \Auth::id()
                        ]);
                        $done = true;

                        $notifications = LarametricsNotification::whereIn('action', ['request_route', 'execution_time'])
                            ->get();

                        foreach($notifications as $index => $notification) {
                            if($notification->action === 'execution_time') {
                                $executionTime = floor(($larametricsRequest->end_time - $larametricsRequest->start_time) * 1000);
                                if($executionTime <= intval($notification->filter)) {
                                    unset($notifications[$index]);
                                }
                            } else {
                                if($notification->filter !== '*' && !str_contains($larametricsRequest->uri, $notification->filter)) {
                                    unset($notifications[$index]);
                                }
                            }
                        }

                        if(count($notifications)) {
                            foreach($notifications as $notification) {
                                Notification::send($notification, new RouteRequested($larametricsRequest));
                            }
                        }
                    }
                });
            });
        }
    }

}
