<?php

namespace Aschmelyun\Larametrics\Tests\Unit\Models;

use Aschmelyun\Larametrics\models\LarametricsLog;
use Aschmelyun\Larametrics\Tests\TestCase;

class LarametricsLogTest extends TestCase
{
    /** @test */
    public function test_save_data_into_larametrics_logs_tables()
    {
        $params = [
            'level' => 'error',
            'message' => $this->faker->sentence(4),
            'user_id' => 1,
            'email' => $this->faker->email,
            'trace' => 1,
        ];

        app(LarametricsLog::class)->create($params);

        $this->assertDatabaseHas('larametrics_logs', $params);
    }

    /** @test */
    public function test_get_error_log_level_attr()
    {
        $params = [
            'level' => 'error',
            'message' => $this->faker->sentence(4),
            'user_id' => 1,
            'email' => $this->faker->email,
            'trace' => 1,
        ];

        $log = app(LarametricsLog::class)->create($params);

        $this->assertEquals('error', $log->getLogLevelAttribute());
    }

    /** @test */
    public function test_get_notice_log_level_attr()
    {
        $params = [
            'level' => 'notice',
            'message' => $this->faker->sentence(4),
            'user_id' => 1,
            'email' => $this->faker->email,
            'trace' => 1,
        ];

        $log = app(LarametricsLog::class)->create($params);

        $this->assertEquals('notice', $log->getLogLevelAttribute());
    }

    /** @test */
    public function test_get_debug_log_level_attr()
    {
        $params = [
            'level' => 'debug',
            'message' => $this->faker->sentence(4),
            'user_id' => 1,
            'email' => $this->faker->email,
            'trace' => 1,
        ];

        $log = app(LarametricsLog::class)->create($params);

        $this->assertEquals('debug', $log->getLogLevelAttribute());
    }
}

