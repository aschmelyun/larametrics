<?php

namespace Aschmelyun\Larametrics;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Aschmelyun\Larametrics\Models\LarametricsModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class LarametricsServiceProvider extends ServiceProvider {

    public function boot()
    {
        if(method_exists($this, 'loadMigrationsFrom')) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        } else {
            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations')
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
        $this->app->singleton(Larametrics::class, function() {
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