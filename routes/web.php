<?php

Route::group(['as' => 'larametrics::'], function () {

    // dashboard routes
    Route::get('/metrics', [
        'as' => 'metrics.index',
        'uses' => larametricsUses('MetricsController@index'),
    ]);

    // logs routes
    Route::get('/metrics/logs', [
        'as' => 'logs.index',
        'uses' => larametricsUses('LogController@index'),
    ]);

    Route::get('/metrics/logs/{log}', [
        'as' => 'logs.show',
        'uses' => larametricsUses('LogController@show'),
    ]);

    // models routes
    Route::get('/metrics/models', [
        'as' => 'models.index',
        'uses' => larametricsUses('ModelController@index'),
    ]);

    Route::get('/metrics/models/{model}', [
        'as' => 'models.show',
        'uses' => larametricsUses('ModelController@show'),
    ]);

    Route::get('/metrics/models/{model}/revert', [
        'as' => 'models.revert',
        'uses' => larametricsUses('ModelController@revert'),
    ]);

    // performance routes
    Route::get('/metrics/performance', [
        'as' => 'performance.index',
        'uses' => larametricsUses('PerformanceController@index'),
    ]);

    // request routes
    Route::get('/metrics/requests', [
        'as' => 'requests.index',
        'uses' => larametricsUses('RequestController@index'),
    ]);

    Route::get('/metrics/requests/{request}', [
        'as' => 'requests.show',
        'uses' => larametricsUses('RequestController@show'),
    ]);

    // notifications routes
    Route::get('/metrics/notifications', [
        'as' => 'notifications.index',
        'uses' => larametricsUses('NotificationController@index'),
    ]);

    Route::post('/metrics/notifications/edit', [
        'as' => 'notifications.update',
        'uses' => larametricsUses('NotificationController@update'),
    ]);

});
