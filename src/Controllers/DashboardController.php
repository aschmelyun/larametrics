<?php

namespace Aschmelyun\Larametrics\Controllers;

use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // todo: refactor this into the model
        $events = LarametricsEvent::whereDate('created_at', '>=', now()->subDays(7))->get();

        $breakdown = [
            'requests' => $events->where('type', 'request')->count(),
            'unique_requests' => $events->where('type', 'request')->unique('data.ip_address')->count(),
            'models' => $events->where('type', 'model')->count(),
            'defined' => $events->where('type', 'defined')->count()
        ];

        return view('larametrics::dashboard', [
            'events' => $events,
            'breakdown' => $breakdown
        ]);
    }
}