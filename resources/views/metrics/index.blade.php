@extends('larametrics::common.default')
@section('content')
<div class="row row-cards">
    <div class="col-12">
        @if(config('larametrics.requestsWatched') || !config('larametrics.hideUnwatchedMenuItems'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Requests</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>URI</th>
                                <th>IP Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                @php
                                    $textClass = 'fe-circle text-info';

                                    if($request->method === 'POST' || $request->method === 'PUT' || $request->method === 'OPTIONS') {
                                        $textClass = 'fe-disc text-warning';
                                    }

                                    if($request->method === 'DELETE') {
                                        $textClass = 'fe-minus-circle text-danger';
                                    }
                                @endphp
                                <tr>
                                    <td><i class="fe {{ $textClass }}"></i></td>
                                    <td>{{ $request->method }}</td>
                                    <td>{{ $request->created_at }}</td>
                                    <td><strong>{{ $request->uri }}</strong></td>
                                    <td>{{ $request->ip }}</td>
                                    <td><a href="{{ route('larametrics::requests.show', $request->id) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(config('larametrics.logsWatched') || !config('larametrics.hideUnwatchedMenuItems'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Logs</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Log Level</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                @php
                                    $textClass = 'fe-alert-circle text-info';

                                    if($log->level === 'warning' || $log->level === 'failed') {
                                        $textClass = 'fe-alert-circle text-warning';
                                    }

                                    if($log->level === 'error' || $log->level === 'critical' || $log->level === 'alert' || $log->level === 'emergency') {
                                        $textClass = 'fe-alert-triangle text-danger';
                                    }
                                @endphp
                                <tr>
                                    <td><i class="fe {{ $textClass }}"></i></td>
                                    <td>{{ ucwords($log->level) }}</td>
                                    <td>{{ $log->created_at }}</td>
                                    <td><strong>{{ substr($log->message, 0, 96) . '...' }}</strong></td>
                                    <td><a href="{{ route('larametrics::logs.show', $log->id) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(count(config('larametrics.modelsWatched')) || !config('larametrics.hideUnwatchedMenuItems'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Model Changes</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>Model</th>
                                <th>Changes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($models as $model)
                                @php
                                    $methodClass = 'fe-circle text-info';
                                    if($model->method === 'deleted') {
                                        $methodClass = 'fe-minus-circle text-danger';
                                    } elseif($model->method === 'created') {
                                        $methodClass = 'fe-plus-circle text-success';
                                    }
                                @endphp
                                <tr>
                                    <td><i class="fe {{ $methodClass }}"></i></td>
                                    <td>{{ ucwords($model->method) }}</td>
                                    <td>{{ $model->created_at }}</td>
                                    <td><strong>{{ $model->model . ' #' . json_decode($model->original, true)['id'] }}</strong></td>
                                    <td>
                                        @php
                                            $original = json_decode($model->original, true);
                                            $changes = json_decode($model->changes, true);
                                        @endphp

                                        @if($changes && count($changes))
                                            @php
                                                $changeArray = array();

                                                foreach($changes as $column => $change) {

                                                	$changeChars = is_array($change) ? str_split($change['date']) : str_split($change);
                                                    $originalChars = str_split($original[$column]);
                                                    $changeNumbers = array(
                                                        'added' => 0,
                                                        'subtracted' => 0
                                                    );

                                                    foreach($originalChars as $index => $char) {
                                                        if((isset($changeChars[$index])) && ($char !== $changeChars[$index])) {
                                                            $changeNumbers['added'] += 1;
                                                            $changeNumbers['subtracted'] += 1;
                                                        }
                                                    }

                                                    $diff = (count($originalChars) - count($changeChars));
                                                    if($diff < 0) {
                                                        $changeNumbers['subtracted'] += abs($diff);
                                                    } else if($diff > 0) {
                                                        $changeNumbers['added'] += abs($diff);
                                                    }

                                                    $changeArray[$column] = $changeNumbers;
                                                }
                                            @endphp

                                            <pre style="white-space: pre-wrap;line-height:1.5rem">@foreach($changeArray as $column => $numbers){{ $column }} <span class="text-danger">-{{ $numbers['subtracted'] }}</span> <span class="text-success">+{{ $numbers['added'] }}</span><br>@endforeach</pre>
                                        @endif
                                    </td>
                                    <td class="text-right"><a href="{{ route('larametrics::models.show', $model->id) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection