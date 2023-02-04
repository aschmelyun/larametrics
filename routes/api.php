<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::get('/', function () {
        return 'Larametrics api!';
    });
});
