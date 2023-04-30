<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Collections;

use Illuminate\Database\Eloquent\Collection;

class LarametricsCollection extends Collection
{
    public function breakdown(string $key): int
    {
        return match ($key) {
            'requests' => $this->where('type', 'request')->count(),
            'unique_requests' => $this->where('type', 'request')->unique('data.ip_address')->count(),
            'models' => $this->where('type', 'model')->count(),
            'defined' => $this->where('type', 'defined')->count(),
            default => 0,
        };
    }
}
