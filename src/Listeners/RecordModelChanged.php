<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Listeners;

use Aschmelyun\Larametrics\Actions\AttachRequestToEvent;
use Aschmelyun\Larametrics\Actions\CollectChangesBetweenStates;
use Aschmelyun\Larametrics\Actions\FormatDatabaseChangeObject;
use Aschmelyun\Larametrics\Actions\GetUserAssociatedWithEvent;
use Aschmelyun\Larametrics\Events\ModelChanged;
use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Pipeline\Pipeline;

class RecordModelChanged
{
    public function handle(ModelChanged $event): void
    {
        // Run an actions pipeline to collect and format model change data
        $modelChange = app(Pipeline::class)
            ->send([
                'model' => $event->model,
                'event' => $event->event,
            ])
            ->through([
                CollectChangesBetweenStates::class,
                GetUserAssociatedWithEvent::class,
                AttachRequestToEvent::class,
                FormatDatabaseChangeObject::class,
            ])
            ->thenReturn();

        // Save the model change to the database
        LarametricsEvent::create([
            'user_id' => $modelChange['user'] ? $modelChange['user']->id : null,
            'type' => 'model',
            'data' => $modelChange,
        ]);
    }
}
