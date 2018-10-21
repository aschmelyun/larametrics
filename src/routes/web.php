<?php

Route::group(['as' => 'larametrics::'], function() {

    // dashboard routes
    Route::get('/metrics', [
        'as'    => 'metrics.index',
        'uses'  => uses('MetricsController@index')
    ]);
    
    // logs routes
    Route::get('/metrics/logs', [
        'as'    => 'logs.index',
        'uses'  => uses('LogController@index')
    ]);

    Route::get('/metrics/logs/{log}', [
        'as'    => 'logs.show',
        'uses'  => uses('LogController@show')
    ]);

    // models routes
    Route::get('/metrics/models', [
        'as'    => 'models.index',
        'uses'  => uses('ModelController@index')
    ]);

    Route::get('/metrics/models/{model}', [
        'as'    => 'models.show',
        'uses'  => uses('ModelController@show')
    ]);

    Route::get('/metrics/models/{model}/revert', [
        'as'    => 'models.revert',
        'uses'  => uses('ModelController@revert')
    ]);

    // performance routes
    Route::get('/metrics/performance', [
        'as'    => 'performance.index',
        'uses'  => uses('PerformanceController@index')
    ]);

    // request routes
    Route::get('/metrics/requests', [
        'as'    => 'requests.index',
        'uses'  => uses('RequestController@index')
    ]);

    Route::get('/metrics/requests/{request}', [
        'as'    => 'requests.show',
        'uses'  => uses('RequestController@show')
    ]);

    // notifications routes
    Route::get('/metrics/notifications', [
        'as'    => 'notifications.index',
        'uses'  => uses('NotificationController@index')
    ]);

    Route::post('/metrics/notifications/edit', [
        'as'    => 'notifications.update',
        'uses'  => uses('NotificationController@update')
    ]);

});

function uses($uses) {
    return '\Aschmelyun\Larametrics\Http\Controllers\\' . $uses;
}