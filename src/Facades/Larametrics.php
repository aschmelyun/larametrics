<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aschmelyun\Larametrics\Larametrics
 */
class Larametrics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aschmelyun\Larametrics\Larametrics::class;
    }
}
