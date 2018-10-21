@extends('larametrics::common.default')
@section('content')
<div class="row row-cards" id="larametricsModels">
    @foreach($modelsAmounts as $model => $info)
        <div class="col-6 col-sm-6 col-lg-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-primary mr-3">
                        {{ $info['count'] }}
                    </span>
                    <div>
                        <h4 class="m-0">
                            <a href="{{ route('larametrics::models.show', str_replace('\\', '+', $model)) }}"><small>{{ $model }}</small></a>
                        </h4>
                        <small class="text-muted">{{ $info['changes'] }} change{{ $info['changes'] !== 1 ? 's' : '' }} in {{ $watchLength }} day{{ $watchLength !== 1 ? 's' : '' }}</small>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection