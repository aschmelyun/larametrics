<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class LarametricsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (method_exists($this, 'loadMigrationsFrom')) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        } else {
            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations'),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/config/larametrics.php' => config_path('larametrics.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'larametrics');

        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/larametrics'),
        ], 'public');
    }

    public function register()
    {
        require_once __DIR__ . '/helpers.php';

        $this->app->singleton(Larametrics::class, function () {
            return new Larametrics();
        });

        $this->app->register('Aschmelyun\Larametrics\LarametricsModelServiceProvider');
        $this->app->register('Aschmelyun\Larametrics\LarametricsRouteServiceProvider');
        $this->app->register('Aschmelyun\Larametrics\LarametricsLogServiceProvider');

        $this->app->alias(Larametrics::class, 'larametrics');
    }

    public function provides()
    {

    }

}
