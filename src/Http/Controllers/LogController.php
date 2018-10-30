<?php

namespace Aschmelyun\Larametrics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Aschmelyun\Larametrics\Models\LarametricsLog;

class LogController extends Controller
{

    public function index()
    {
        $logs = LarametricsLog::orderBy('created_at', 'desc')
            ->get();
            
        return view('larametrics::logs.index', [
            'logs' => $logs,
            'pageTitle' => 'Laravel Logs'
        ]);
    }

    public function show(LarametricsLog $log)
    {
        return view('larametrics::logs.show', [
            'log' => $log,
            'pageTitle' => 'Viewing Log Details'
        ]);
    }

}
