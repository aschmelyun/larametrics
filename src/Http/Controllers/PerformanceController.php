<?php

namespace Aschmelyun\Larametrics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Aschmelyun\Larametrics\Models\LarametricsRequest;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    
    public function index()
    {
        $latestRequests = LarametricsRequest::orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        $requests = LarametricsRequest::all()
            ->toArray();
        foreach($requests as $index => $request) {
            $responseTime = floor(($request['end_time'] - $request['start_time']) * 1000);
            $requests[$index]['responseTime'] = $responseTime;
        }

        usort($requests, function($a, $b) {
            return $b['responseTime'] - $a['responseTime'];
        });

        return view('larametrics::performance.index', [
            'latestRequests' => $latestRequests,
            'requestsByResponseTime' => array_slice($requests, 0, 10),
            'pageTitle' => 'App Performance'
        ]);
    }

}
