<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics;

use Aschmelyun\Larametrics\Events\DefinedEvent;
use Illuminate\Support\Facades\Route;

class Larametrics
{
    /**
     * @param  array<string>  $middleware
     */
    public function routes(array|string $middleware = []): void
    {
        Route::middleware(['web', ...(array) $middleware])
            ->prefix(config('larametrics.prefix'))
            ->name(config('larametrics.name_prefix'))
            ->group(__DIR__.'/../routes/web.php');

        if (config('larametrics.enable_api')) {
            Route::middleware(['api', ...(array) $middleware])
                ->prefix(config('larametrics.prefix'))
                ->name(config('larametrics.name_prefix'))
                ->group(__DIR__.'/../routes/api.php');
        }
    }

    public function event(string $name, mixed $data = null): void
    {
        event(new DefinedEvent($name, $data));
    }
}
