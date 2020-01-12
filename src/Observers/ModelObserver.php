<?php

namespace Aschmelyun\Larametrics\Observers;

use Aschmelyun\Larametrics\Actions\SaveQuery;

class ModelObserver
{

    public function created($model)
    {
        $this->dispatchSaveQuery($model);
    }

    public function updated($model)
    {
        $this->dispatchSaveQuery($model);
    }

    public function deleted($model)
    {
        $this->dispatchSaveQuery($model);
    }

    public function dispatchSaveQuery($model)
    {
        $saveQuery = new SaveQuery($model, app()->request);
        $saveQuery->dispatch();
    }

}