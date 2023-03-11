<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Actions;

use Aschmelyun\Larametrics\Contracts\Action;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CollectChangesBetweenStates implements Action
{
    /**
     * @param  array<mixed>  $event
     * @return array<mixed>
     */
    public function handle(array $event, \Closure $next): array
    {
        $model = $event['model'];
        $event = $event['event'];

        // If the model is a collection, we'll loop through each model and collect
        // the changes for each model.
        if ($model instanceof Collection) {
            $changes = $model->map(function ($model) use ($event) {
                return $this->collectChanges($model, $event);
            });

            return $next([
                'model' => $model,
                'event' => $event,
                'changes' => $changes,
            ]);
        }

        // Otherwise, we'll collect the changes for the single model.
        $changes = $this->collectChanges($model, $event);

        return $next([
            'model' => $model,
            'event' => $event,
            'changes' => $changes,
        ]);
    }

    /**
     * @return array<mixed>
     */
    protected function collectChanges(Model $model, string $event): array
    {
        // If the model is being created or deleted, we'll return an empty array
        // of changes since there are no changes to collect.
        if ($event === 'created' || $event === 'deleted') {
            return [];
        }

        return $model->getChanges();
    }
}
