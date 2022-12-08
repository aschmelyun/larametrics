<?php

namespace Aschmelyun\Larametrics\Tests;

use Aschmelyun\Larametrics\LarametricsEventsServiceProvider;
use Aschmelyun\Larametrics\LarametricsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $faker;
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            LarametricsServiceProvider::class,
            LarametricsEventsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    private function setUpDatabase(Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('larametrics_models' , function (Blueprint $table){
            $table->increments('id');
            $table->string('model');
            $table->integer('model_id');
            $table->integer('user_id')->nullable();
            $table->string('method');
            $table->text('original')->nullable();
            $table->text('changes')->nullable();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_requests' , function (Blueprint $table){
            $table->increments('id');
            $table->string('method');
            $table->text('uri');
            $table->string('ip')->nullable();
            $table->text('headers')->nullable();
            $table->float('start_time', 16, 4)->nullable();
            $table->float('end_time', 16, 4)->nullable();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_logs' , function (Blueprint $table){
            $table->increments('id');
            $table->string('level');
            $table->text('message');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->text('trace');
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_notifications' , function (Blueprint $table){
            $table->increments('id');
            $table->string('action');
            $table->string('filter')->nullable();
            $table->text('meta')->nullable();
            $table->string('notify_by')->default('email');
            $table->timestamp('last_fired_at')->nullable();
            $table->timestamps();
        });

    }
}
