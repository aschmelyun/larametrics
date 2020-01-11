<?php

namespace Aschmelyun\Larametrics\Tests;

use Aschmelyun\Larametrics\LarametricsServiceProvider;
use Aschmelyun\Larametrics\LarametricsEventsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    protected function getPackageProviders($app)
    {
        return [
            LarametricsServiceProvider::class,
            LarametricsEventsServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('larametrics.modelsWatched', []);
    }

}