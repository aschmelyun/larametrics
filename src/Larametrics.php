<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\Facades\Route;

class Larametrics
{
    public static function routes(): void
    {
        Route::middleware(config('larametrics.middleware'))
            ->name(config('larametrics.name_prefix'))
            ->prefix(config('larametrics.prefix'))
            ->group(__DIR__ . '/../routes/dashboard.php');
    }
}
