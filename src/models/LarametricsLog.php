<?php

namespace Aschmelyun\Larametrics\models;

use Illuminate\Database\Eloquent\Model;

class LarametricsLog extends Model
{
    protected $table = 'larametrics_logs';
    protected $guarded = [];
    protected $appends = [
        'log_level'
    ];
    
    public function getLogLevelAttribute()
    {
        $logLevel = 'notice';
        $notificationLevels = array(
            'error' => [
                'emergency',
                'alert',
                'critical',
                'error'
            ],
            'notice' => [
                'warning',
                'notice'
            ],
            'debug' => [
                'info',
                'debug'
            ]
        );

        foreach($notificationLevels as $triggerLevel => $childLevels) {
            if(in_array($this->level, $childLevels)) {
                $logLevel = $triggerLevel;
            }
        }

        return $logLevel;
    }
}