@extends('larametrics::common.default')
@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ count($models) }} Change{{ count($models) !== 1 ? 's' : '' }} in {{ $watchLength }} Day{{ $watchLength !== 1 ? 's' : '' }}</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Method</th>
                            <th>ID</th>
                            <th>Timestamp</th>
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
                                <td>{{ json_decode($model->original, true)[$modelPrimaryKey] }}</td>
                                <td>{{ $model->created_at }}</td>
                                <td>
                                    @php
                                        $original = json_decode($model->original, true);
                                        $changes = json_decode($model->changes, true);
                                    @endphp

                                    @if($model->method === 'created' && count($original))
                                        <pre style="white-space: pre-wrap;line-height:1.5rem">@foreach($original as $column => $data){{ $column }} <span class="text-success">+{{ strlen($data) }}</span><br>@endforeach</pre>
                                    @endif

                                    @if($model->method === 'deleted' && count($original))
                                        <pre style="white-space: pre-wrap;line-height:1.5rem">@foreach($original as $column => $data){{ $column }} <span class="text-danger">-{{ strlen($data) }}</span><br>@endforeach</pre>
                                    @endif

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
    </div>
</div>
@endsection