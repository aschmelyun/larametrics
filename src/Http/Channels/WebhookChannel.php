<?php

namespace Aschmelyun\Larametrics\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class WebhookChannel
{

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWebhook($notifiable);

        $client = new Client();
        try {
            $request = $client->post(config('larametrics.notificationMethods')['webhook'], [
                'json' => $message
            ]);

            dd($request);
        } catch(\Exception $e) {
            //fail silently
        }
    }

}