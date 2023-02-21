<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Events;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class ModelChanged
{
    use Dispatchable;

    public function __construct(
        public Model|Collection $model,
        public string $event,
    ) {
    }
}
