<?php

namespace Aschmelyun\Larametrics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LarametricsNotification extends Model
{
    use Notifiable;

    protected $table = 'larametrics_notifications';
    public $guarded = [];

    public function routeNotificationForMail($notification = null)
    {
        return config('larametrics.notificationMethods')['email'];
    }
    
    public function routeNotificationForSlack($notification = null)
    {
        return config('larametrics.notificationMethods')['slack'];
    }
}