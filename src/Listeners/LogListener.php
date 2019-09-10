<?php

namespace Aschmelyun\Larametrics\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Aschmelyun\Larametrics\Actions\SaveLog;

class LogListener
{

    public function handle(MessageLogged $message)
    {
        $saveLog = new SaveLog($message, app()->request);
        $saveLog->dispatch();
    }

}