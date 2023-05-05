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

    public function top(string $key): Collection
    {
        return match ($key) {
            'routes' => $this->where('type', 'request')
                ->groupBy('data.path')
                ->sortByDesc(fn ($items) => $items->count())
                ->take(5),
            'events' => $this->where('type', 'defined')
                ->groupBy('data.name')
                ->sortByDesc(fn ($items) => $items->count())
                ->take(5),
            default => new Collection(),
        };
    }

    public function daily(string $key): float
    {
        $days = abs((int) request()->get('days', 7));

        return match ($key) {
            'requests' => floor(
                $this->where('type', 'request')
                    ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
                    ->count() / $days
            ),
            'unique_requests' => floor(
                $this->where('type', 'request')
                    ->unique('data.ip_address')
                    ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
                    ->count() / $days
            ),
            'models' => floor(
                $this->where('type', 'model')
                    ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
                    ->count() / $days
            ),
            'defined' => floor(
                $this->where('type', 'defined')
                    ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'))
                    ->count() / $days
            ),
            default => 0,
        };
    }
}
