<?php

namespace Aschmelyun\Larametrics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Aschmelyun\Larametrics\Models\LarametricsNotification;

class NotificationController extends Controller
{
    
    public function index()
    {
        $notifications = LarametricsNotification::all();
        
        return view('larametrics::notifications.index', [
            'notifications' => $notifications,
            'pageTitle' => 'Notifications'
        ]);
    }

    public function update(Request $request)
    {
        $notifications = '';
        LarametricsNotification::truncate();
        foreach(json_decode($request->input('notifications')) as $notification) {
            $notificationData = array(
                'action' => $notification->action,
                'filter' => $notification->filter,
                'notify_by' => $notification->notify_by
            );
            try {
                LarametricsNotification::create($notificationData);
            } catch(\Exception $e) {}
        }

        return redirect()->route('larametrics::notifications.index');
    }

}
