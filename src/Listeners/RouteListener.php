<?php

namespace Aschmelyun\Larametrics\Listeners;

use Illuminate\Routing\Events\RouteMatched;
use Aschmelyun\Larametrics\Actions\SaveRoute;

class RouteListener
{

    public function handle(RouteMatched $route)
    {
        $saveRoute = new SaveRoute($route, app()->request);
        $saveRoute->dispatch();
    }

}