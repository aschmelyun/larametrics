<?php

namespace Aschmelyun\Larametrics\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Aschmelyun\Larametrics\LarametricsServiceProvider;
use Aschmelyun\Larametrics\LarametricsEventsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Aschmelyun\Larametrics\LarametricsServiceProvider::class,
            \Aschmelyun\Larametrics\LarametricsEventsServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->initializeDirectory($this->getTempDirectory());

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        config()->set('larametrics.logsWatched', true);
        config()->set('larametrics.modelsWatched', []);
        config()->set('larametrics.logsWatchedExpireDays', 0);
        config()->set('larametrics.logsWatchedExpireAmount', 0);
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('larametrics_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->integer('model_id');
            $table->integer('user_id')->nullable();
            $table->string('method');
            $table->text('original')->nullable();
            $table->text('changes')->nullable();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->text('uri');
            $table->string('ip')->nullable();
            $table->text('headers')->nullable();
            $table->float('start_time', 16, 4)->nullable();
            $table->float('end_time', 16, 4)->nullable();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level');
            $table->text('message');
            $table->integer('user_id')->nullable();
            $table->string('email')->nullable();
            $table->text('trace');
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('larametrics_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->string('filter')->nullable();
            $table->text('meta')->nullable();
            $table->string('notify_by')->default('email');
            $table->timestamp('last_fired_at')->nullable();
            $table->timestamps();
        });
    }

    protected function initializeDirectory($directory)
    {
        File::deleteDirectory($directory);

        File::makeDirectory($directory);

        $this->addGitignoreTo($directory);
    }

    public function getTempDirectory()
    {
        return __DIR__.'/temp';
    }

    public function addGitignoreTo($directory)
    {
        $fileName = "{$directory}/.gitignore";

        $fileContents = '*' . PHP_EOL . '!.gitignore';

        File::put($fileName, $fileContents);
    }

}