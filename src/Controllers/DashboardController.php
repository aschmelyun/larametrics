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
        $days = abs((int) $request->get('days', 7));
        
        return view('larametrics::dashboard', [
            'events' => LarametricsEvent::whereDate(
                'created_at',
                '>=',
                now()->subDays($days)
            )->get(),
        ]);
    }
}
