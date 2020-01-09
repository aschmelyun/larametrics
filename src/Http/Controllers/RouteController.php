<?php

namespace Aschmelyun\Larametrics\Http\Controllers;

use Aschmelyun\Larametrics\Actions\SaveRoute;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Aschmelyun\Larametrics\Models\LarametricsNotification;

class RouteController extends Controller
{
    
    public function catch(Request $request)
    {
        $saveRoute = new SaveRoute($request);
        $saveRoute->dispatch();

        \Log::alert('A 404 error was triggered as a user was attempting to visit ' . env('APP_URL', '') . $request->getRequestUri());

        abort(404);
    }

}
