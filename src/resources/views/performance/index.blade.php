@extends('larametrics::common.default')
@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Response Time (Latest {{ count($latestRequests) }} requests)</h3>
            </div>
            <div class="card-body">
                <div id="chart-line" class="c3"></div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top {{ count($requestsByResponseTime) }} Requests (By response time)</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Method</th>
                            <th>Response Time</th>
                            <th>Date</th>
                            <th>URI</th>
                            <th>IP Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requestsByResponseTime as $request)
                            @php
                                $iconClass = 'fe-circle text-info';
                                if($request['method'] === 'POST' || $request['method'] === 'PUT' || $request['method'] === 'OPTIONS') {
                                    $iconClass = 'fe-disc text-warning';
                                }

                                if($request['method'] === 'DELETE') {
                                    $iconClass = 'fe-minus-circle text-danger';
                                }
                            @endphp
                            <tr>
                                <td><i class="fe {{ $iconClass }}"></i></td>
                                <td>{{ $request['method'] }}</td>
                                <td>{{ $request['responseTime'] }}ms</td>
                                <td>{{ $request['created_at'] }}</td>
                                <td>{{ $request['uri'] }}</td>
                                <td>{{ $request['ip'] }}</td>
                                <td><a href="{{ route('larametrics::requests.show', $request['id']) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@php 
    $requestTimes = array();
    $requestDates = array();
    foreach($latestRequests as $request) {
        array_push($requestTimes, floor(($request->end_time - $request->start_time) * 1000));
        array_push($requestDates, $request->created_at->format('M d g:ia'));
    }
    array_push($requestTimes, 'resp');
@endphp
<script>
    $(document).ready(function() {
        var times = {!! json_encode(array_reverse($requestDates)) !!};
        var chart = c3.generate({
            bindto: '#chart-line',
            data: {
                columns: [
                    {!! json_encode(array_reverse($requestTimes)) !!}
                ],
                type: 'area-spline',
                groups: [
                    ['resp']
                ],
                colors: {
                    'resp': "#467fcf"
                },
                names: {
                    'resp': 'Response Time'
                }
            },
            axis: {
                x: {
                    show: false,
                },
                y: {
                    tick: {
                        format: function(d) {
                            return d + 'ms';
                        }
                    }
                }
            },
            legend: {
                show: false,
            },
            padding: {
                bottom: 0,
                top: 0
            },
            tooltip: {
                format: {
                    title: function(index) {
                        return times[index];
                    }
                }
            }
        });
    });
</script>
@endsection