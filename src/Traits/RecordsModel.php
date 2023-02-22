<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Traits;

use Aschmelyun\Larametrics\Events\ModelChanged;

trait RecordsModel
{
    public static function bootRecordsModel(): void
    {
        collect((new self)->records ?? config('larametrics.default_model_events'))
            ->each(function ($event) {
                static::$event(function ($model) use ($event) {
                    ModelChanged::dispatch($model, $event);
                });
            });
    }
}
