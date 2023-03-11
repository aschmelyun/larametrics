<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Actions\FormatDefinedEventObject;
use Aschmelyun\Larametrics\Actions\GetUserAssociatedWithEvent;
use Aschmelyun\Larametrics\Events\DefinedEvent;
use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Pipeline\Pipeline;

class RecordDefinedEvent
{
    public function handle(DefinedEvent $event): void
    {
        // Run an actions pipeline to collect and format user-defined event data
        $definedEvent = app(Pipeline::class)
            ->send([
                'name' => $event->name,
                'data' => $event->data,
            ])
            ->through([
                GetUserAssociatedWithEvent::class,
                FormatDefinedEventObject::class,
            ])
            ->thenReturn();

        // Save the user-defined event to the database
        LarametricsEvent::create([
            'user_id' => $definedEvent['user'] ? $definedEvent['user']->id : null,
            'type' => 'defined',
            'data' => $definedEvent,
        ]);
    }
}
