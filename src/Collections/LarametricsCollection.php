<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Collections;

use Aschmelyun\Larametrics\Models\LarametricsEvent;
use Illuminate\Database\Eloquent\Collection;

/**
 * PHPDoc showing that this collection contains LarametricsEvent models
 *
 * @method Collection<LarametricsEvent> where(string $key, mixed $value)
 */
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
                    ->groupBy(fn ($item) => $item->created_at->format('Y-m-d')) // @phpstan-ignore-line
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

    public function change(string $key): string
    {
        $days = abs((int) request()->get('days', 7));

        $daily = $this->breakdown($key);
        $previous = LarametricsEvent::whereDate( // @phpstan-ignore-line
            'created_at',
            '>',
            now()->subDays($days * 2)
        )
            ->whereDate(
                'created_at',
                '<',
                now()->subDays($days)
            )
            ->get()
            ->breakdown($key);

        // Should probably refactor this so I don't have to build the entire class list here...
        if ($previous == 0 && $daily == 0) {
            return '<span class="inline-block mr-1 text-sm font-semibold">0%</span>';
        }

        if ($previous == 0) {
            return '<span class="inline-block mr-1 text-sm font-semibold text-green-600">+∞%</span>';
        }

        if ($daily == 0) {
            return '<span class="inline-block mr-1 text-sm font-semibold text-red-600">-∞%</span>';
        }

        $change = round((($daily - $previous) / $previous) * 100);

        return match ($change <=> 0) {
            1 => '<span class="inline-block mr-1 text-sm font-semibold text-green-600">+'.$change.'%</span>',
            0 => '<span class="inline-block mr-1 text-sm font-semibold">'.$change.'%</span>',
            default => '<span class="inline-block mr-1 text-sm font-semibold text-red-600">'.$change.'%</span>'
        };
    }

    /**
     * @return array<string, int>
     */
    public function graph(string $key): array
    {
        $days = abs((int) request()->get('days', 7));

        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($i);

            $data[$date->format('M d')] = $this->where('type', 'request')
                ->filter(fn ($item) => $item->created_at->format('Y-m-d') == $date->format('Y-m-d'))
                ->count();
        }

        return array_reverse($data);
    }
}
