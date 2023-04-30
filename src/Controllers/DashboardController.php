<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Controllers;

use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('larametrics::dashboard', [
            'events' => LarametricsEvent::whereDate(
                'created_at',
                '>=',
                now()->subDays($request->get('days', 7))
            )->get(),
        ]);
    }
}
