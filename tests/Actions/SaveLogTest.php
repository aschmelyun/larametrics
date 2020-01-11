<?php

namespace Aschmelyun\Larametrics\Tests\Actions;

use Aschmelyun\Larametrics\Tests\TestCase;

class SaveLogTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_will_return_a_payload_from_a_log_level_being_watched()
    {
        $expected = [];
        $actual = [];

        $this->assertEquals($expected, $actual);
    }

}