@extends('larametrics::common.default')
@section('content')
@php $headers = json_decode($request->headers, true); @endphp
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <pre style="white-space:normal;line-height:1.5rem;margin:0;">{{ $request->headers }}</pre>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Request Info</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Method</td>
                            <td><strong>{{ $request->method }}</strong></td>
                        </tr>
                        <tr>
                            <td>URI</td>
                            <td><strong>{{ $request->uri }}</strong></td>
                        </tr>
                        <tr>
                            <td>IP Address</td>
                            <td><strong>{{ $request->ip }}</strong></td>
                        </tr>
                        <tr>
                            <td>Execution Time</td>
                            <td><strong>{{ floor(($request->end_time - $request->start_time) * 1000) }}ms</strong></td>
                        </tr>
                        <tr>
                            <td>Host</td>
                            <td><strong>{{ $headers['host'][0] }}</strong></td>
                        </tr>
                        <tr>
                            <td>User Agent</td>
                            <td><strong>{{ $headers['user-agent'][0] }}</strong></td>
                        </tr>
                        <tr>
                            <td>Referer</td>
                            <td><strong>{{ $headers['referer'][0] ?: '-' }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection