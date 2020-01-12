<?php

namespace Aschmelyun\Larametrics\Tests\Actions;

use Carbon\Carbon;
use Aschmelyun\Larametrics\Tests\TestCase;
use Aschmelyun\Larametrics\Actions\SaveLog;
use Aschmelyun\Larametrics\Models\LarametricsLog;
use Illuminate\Support\Facades\Event;
use Illuminate\Log\Events\MessageLogged;

class SaveLogTest extends TestCase
{

    /** @test */
    public function it_provides_a_create_method()
    {
        $log = new LarametricsLog();

        $this->assertInstanceOf(LarametricsLog::class, $log);
    }

    /** @test */
    public function it_will_return_a_payload_from_a_log_level_being_watched()
    {
        Event::fake();

        $expected = [
            'level' => 'alert',
            'message' => 'This is an alert test!',
            'trace' => '[]',
            'user_id' => null,
            'email' => null,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'id' => 1,
            'log_level' => 'error'
        ];
        $saveLog = new SaveLog(new MessageLogged('alert',  'This is an alert test!'), app()->request);
        $actual = $saveLog->dispatch()
                    ->toArray();
        $this->assertEquals($expected, $actual);
    }

}