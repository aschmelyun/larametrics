<?php

namespace Aschmelyun\Larametrics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Aschmelyun\Larametrics\LogParser;
use Aschmelyun\Larametrics\Models\LarametricsLog;
use Aschmelyun\Larametrics\Models\LarametricsModel;
use Aschmelyun\Larametrics\Models\LarametricsRequest;

class MetricsController extends Controller
{
    
    public function index()
    {
        $requests = LarametricsRequest::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $logs = LarametricsLog::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $models = LarametricsModel::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('larametrics::metrics.index', [
            'pageTitle' => 'Dashboard',
            'requests' => $requests,
            'logs' => $logs,
            'models' => $models
        ]);
    }

    public function logs()
    {
        return view('larametrics::logs.index');
    }

    public function logShow($index)
    {
        $logArray = LogParser::all();

        if(!isset($logArray[$index])) {
            return abort(404);
        }

        return view('larametrics::logs.show', [
            'log' => $logArray[$index],
            'pageTitle' => 'Viewing Log'
        ]);
    }

}
