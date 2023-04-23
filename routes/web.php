<?php declare(strict_types=1);

use Aschmelyun\Larametrics\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
