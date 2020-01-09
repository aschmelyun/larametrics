<?php

namespace Aschmelyun\Larametrics\Actions;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Aschmelyun\Larametrics\Models\LarametricsModel;
use Aschmelyun\Larametrics\Models\LarametricsNotification;
use Aschmelyun\Larametrics\Notifications\ModelChanged;
use Carbon\Carbon;

class SaveQuery
{

    private $model;
    private $request;
    private $method;

    public function __construct(Model $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;

        $this->method = 'updated';
        if(!$model->exists) {
            $this->method = 'deleted';
        } else if($model->wasRecentlyCreated) {
            $this->method = 'created';
        }
    }

    public function dispatch()
    {
        $this->checkExpiredLogs();

        $createdModel = $this->createModel();
        if($createdModel) {
            $this->triggerNotifications($createdModel);
        }
    }
    
    public function checkExpiredLogs()
    {
        if(config('larametrics.modelsWatchedExpireDays') !== 0) {
            LarametricsModel::where('created_at', '<', Carbon::now()->subDays(config('larametrics.modelsWatchedExpireDays'))->toDateTimeString())
                ->delete();
        }

        if(config('larametrics.modelsWatchedExpireAmount') !== 0) {
            $expiredModels = LarametricsModel::orderBy('created_at', 'desc')
                ->offset(config('larametrics.modelsWatchedExpireAmount'))
                ->limit(config('larametrics.modelsWatchedExpireAmount'))
                ->pluck('id')
                ->toArray();

            LarametricsModel::destroy($expiredModels);
        }
    }
    
    public function createModel()
    {
        try {
            return LarametricsModel::create([
                'model' => get_class($this->model),
                'model_id' => $this->model->getKey(),
                'user_id' => \Auth::user() ? \Auth::user()->id : null,
                'method' => $this->method,
                'original' => $this->method === 'created' ? json_encode($this->model->getAttributes()) : json_encode($this->model->getOriginal()),
                'changes' => $this->method === 'updated' ? json_encode($this->model->getDirty()) : '{}'
            ]);
        } catch(\Exception $e) {
            return null;
        }
    }

    public function triggerNotifications(LarametricsModel $model)
    {
        $notifications = LarametricsNotification::where('action', 'model_' . $this->method)
            ->get();

        foreach($notifications as $index => $notification) {
            if($notification->filter !== '*' && $notification->filter != get_class($this->model)) {
                unset($notifications[$index]);
            }
        }

        if(count($notifications)) {
            foreach($notifications as $notification) {
                Notification::send($notification, new ModelChanged($model));
            }
        }
    }

}