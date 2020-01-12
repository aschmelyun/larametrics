@extends('larametrics::common.default')
@section('content')
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <pre style="white-space:normal;line-height:1.5rem;margin:0;">{{ $log->message }}</pre>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stack Trace</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Info</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(json_decode($log->trace) as $index => $trace)
                        <tr>
                            <td class="w-1">#{{ $index }}</td>
                            @if(isset($trace->class) && isset($trace->function))
                                <td>{{ $trace->class }}<strong>&#64;{{ $trace->function }}</strong></td>
                            @else
                                @if(isset($trace->file))
                                    <td>{{ $trace->file }}<strong>:{{ $trace->line }}</strong></td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection