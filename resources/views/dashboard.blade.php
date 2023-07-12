@extends('larametrics::layouts.larametrics')
@section('title', 'Dashboard')
@section('content')
<div class="rounded bg-white w-full px-8 py-4 shadow mt-4 flex justify-between">
    <div>
        <h5 class="mb-1">Requests</h5>
        <h3 class="text-xl font-semibold text-gray-900">{{ $events->breakdown('requests') }}</h3>
        <div>
            {!! $events->change('requests') !!}
            <span class="inline-block text-sm text-gray-400">Avg Daily: {{ $events->daily('requests') }}</span>
        </div>
    </div>
    <div>
        <h5 class="mb-1">Unique Requests</h5>
        <h3 class="text-xl font-semibold text-gray-900">{{ $events->breakdown('unique_requests') }}</h3>
        <div>
            {!! $events->change('unique_requests') !!}
            <span class="inline-block text-sm text-gray-400">Avg Daily: {{ $events->daily('unique_requests') }}</span>
        </div>
    </div>
    <div>
        <h5 class="mb-1">Model Changes</h5>
        <h3 class="text-xl font-semibold text-gray-900">{{ $events->breakdown('models') }}</h3>
        <div>
            {!! $events->change('models') !!}
            <span class="inline-block text-sm text-gray-400">Avg Daily: {{ $events->daily('models') }}</span>
        </div>
    </div>
    <div>
        <h5 class="mb-1">Events</h5>
        <h3 class="text-xl font-semibold text-gray-900">{{ $events->breakdown('defined') }}</h3>
        <div>
            {!! $events->change('defined') !!}
            <span class="inline-block text-sm text-gray-400">Avg Daily: {{ $events->daily('defined') }}</span>
        </div>
    </div>
</div>
<div class="rounded bg-white w-full py-4 shadow mt-4">
    <div class="px-8 border-b border-gray-200">
        <h3 class="mb-2 font-medium text-gray-900">Analytics</h3>
    </div>
    <div class="px-8">
        <canvas id="chart" height="320"></canvas>
    </div>
</div>
<div class="-mx-2 flex">
    <div class="rounded bg-white w-1/2 mx-2 py-4 shadow mt-4">
        <div class="px-8 border-b border-gray-200">
            <h3 class="mb-2 font-medium text-gray-900">Top Routes<span
                    class="text-sm font-normal text-gray-400 inline-block ml-2">Names</span><span
                    class="text-sm text-blue-500 underline font-medium inline-block ml-2">Paths</span></h3>
        </div>
        <div class="px-8">
            @foreach($events->top('routes') as $route => $items)
                <div class="relative mt-2">
                    <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: {{ bar_width($items->count(), $events->top('routes')->sum(fn ($i) => $i->count())) }}%"></div>
                    <div class="relative p-2 flex justify-between items-center">
                        <span>{{ $route === '//' ? '/' : $route }}</span>
                        <span>{{ $items->count() }}</span>
                    </div>
                </div>
            @endforeach
            <div class="mt-2">
                <span class="text-sm text-gray-400">View More</span>
            </div>
        </div>
    </div>
    <div class="rounded bg-white w-1/2 mx-2 py-4 shadow mt-4">
        <div class="px-8 border-b border-gray-200">
            <h3 class="mb-2 font-medium text-gray-900">Top Events</h3>
        </div>
        <div class="px-8">
            @foreach($events->top('events') as $event => $items)
                <div class="relative mt-2">
                    <div class="absolute h-full bg-blue-500 z-0 rounded opacity-10" style="width: {{ bar_width($items->count(), $events->top('events')->sum(fn ($i) => $i->count())) }}%"></div>
                    <div class="relative p-2 flex justify-between items-center">
                        <span>{{ $event }}</span>
                        <span>{{ $items->count() }}</span>
                    </div>
                </div>
            @endforeach
            <div class="mt-2">
                <span class="text-sm text-gray-400">View More</span>
            </div>
        </div>
    </div>
</div>
<div class="rounded bg-white w-full py-4 shadow mt-4">
    <div class="px-8 pb-2 border-b border-gray-200 flex items-center">
        <h3 class="font-medium text-gray-900">Model Changes</h3>
        <div class="ml-2">
            <span class="inline-block w-2 h-2 bg-blue-500 opacity-50 rounded-full"></span>
            <span class="text-sm text-gray-400">Created</span>
        </div>
        <div class="ml-2">
            <span class="inline-block w-2 h-2 bg-blue-500 opacity-30 rounded-full"></span>
            <span class="text-sm text-gray-400">Updated</span>
        </div>
        <div class="ml-2">
            <span class="inline-block w-2 h-2 bg-blue-500 opacity-10 rounded-full"></span>
            <span class="text-sm text-gray-400">Deleted</span>
        </div>
    </div>
    <div class="px-8">
        <div class="mt-2">
            <div class="flex items-center justify-between mb-1">
                <h3>User</h3>
                <span>125</span>
            </div>
            <div class="flex w-full h-10">
                <div class="w-4/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                <div class="w-7/12 h-10 bg-blue-500 opacity-30"></div>
                <div class="w-1/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
            </div>
        </div>
    </div>
    <div class="px-8">
        <div class="mt-2">
            <div class="flex items-center justify-between mb-1">
                <h3>Post</h3>
                <span>83</span>
            </div>
            <div class="flex w-full h-10">
                <div class="w-8/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                <div class="w-1/12 h-10 bg-blue-500 opacity-30"></div>
                <div class="w-3/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
            </div>
        </div>
    </div>
    <div class="px-8">
        <div class="mt-2 mb-2">
            <div class="flex items-center justify-between mb-1">
                <h3>Comment</h3>
                <span>44</span>
            </div>
            <div class="flex w-full h-10">
                <div class="w-5/12 h-10 bg-blue-500 opacity-50 rounded-l"></div>
                <div class="w-3/12 h-10 bg-blue-500 opacity-30"></div>
                <div class="w-4/12 h-10 bg-blue-500 opacity-10 rounded-r"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart');

    // create a line chart showing requests from the last two weeks, the background color is light blue
    const createGradient = (chart, options) => {
        const gradient = chart.ctx.createLinearGradient(0, 0, 0, ctx.offsetHeight);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        chart.data.datasets[0].fill.above = gradient;
    };

    const chart = new Chart(ctx, {
        plugins: [
            {
                afterLayout: createGradient
            }
        ],
        type: 'line',
        data: {
            labels: ["Jan 21", "Jan 22", "Jan 23", "Jan 24", "Jan 25", "Jan 26", "Jan 27", "Jan 28", "Jan 29", "Jan 30", "Jan 31", "Feb 1", "Feb 2"],
            datasets: [{
                label: 'Requests',
                data: [45, 10, 23, 12, 20, 30, 15, 21, 8, 34, 31, 19, 15],
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
                lineTension: 0.2,
                fill: {
                    target: 'origin'
                }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    display: true,
                    ticks: {
                        maxTicksLimit: 7
                    },
                    grid: {
                        color: 'rgb(243, 244, 246)'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        maxTicksLimit: 5
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush