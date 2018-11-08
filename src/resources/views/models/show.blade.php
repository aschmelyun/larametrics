@extends('larametrics::common.default')
@section('content')
@php
    $original = json_decode($model->original, true);
    $changes = json_decode($model->changes, true);
@endphp
<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ID: {{ $original[$modelPrimaryKey] }} - {{ ucwords($model->method) }} on {{ $model->created_at }}</h3>
            </div>
            @if($changes && count($changes))
                <div class="card-body">
                    @foreach($changes as $column => $content)
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>{{ $column }}</h5>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-6">
                                <pre style="white-space:normal;line-height:1.5rem;margin:0;">
                                    @php
                                        $changeChars = is_array($content) ? str_split($content['date']) : str_split($content);
                                        $originalChars = str_split($original[$column]);
                                        foreach($originalChars as $index => $char) {
                                            if(isset($changeChars[$index])) {
                                                if($changeChars[$index] !== $char) {
                                                    if($index === 0 || ($originalChars[$index - 1] === $changeChars[$index - 1])) {
                                                        echo '<span class="text-danger">';
                                                    }
                                                } else if($index >= 1) {
                                                    if($originalChars[$index - 1] !== $changeChars[$index - 1]) {
                                                        echo '</span>';
                                                    }
                                                }
                                            }
                                            echo htmlspecialchars($char);
                                        }
                                    @endphp
                                </pre>
                            </div>
                            <div class="col-sm-6">
                                <pre style="white-space:normal;line-height:1.5rem;margin:0;">
                                    @php
                                        foreach($changeChars as $index => $char) {
                                            if(isset($originalChars[$index])) {
                                                if($originalChars[$index] !== $char) {
                                                    if($index === 0 || ($originalChars[$index - 1] === $changeChars[$index - 1])) {
                                                        echo '<span class="text-success">';
                                                    }
                                                } else if($index >= 1) {
                                                    if($originalChars[$index - 1] !== $changeChars[$index - 1]) {
                                                        echo '</span>';
                                                    }
                                                }
                                            }
                                            echo htmlspecialchars($char);
                                        }
                                    @endphp
                                </pre>
                            </div>
                        </div>
                    @endforeach
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <a href="{{ route('larametrics::models.revert', $model->id) }}" class="btn btn-secondary btn-sm">Revert Change</a>
                        </div>
                    </div>
                </div>
            @elseif($original && count($original))
                <div class="card-body">
                    @foreach($original as $column => $data)
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>{{ $column }}</h5>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-sm-12">
                                <pre style="white-space:normal;line-height:1.5rem;margin:0;">
                                    @if($model->method === 'created')
                                        <span class="text-success">{{ $data }}</span>
                                    @elseif($model->method === 'deleted')
                                        <span class="text-danger">{{ $data }}</span>
                                    @endif
                                </pre>
                            </div>
                        </div>
                    @endforeach
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <a href="{{ route('larametrics::models.revert', $model->id) }}" class="btn btn-secondary btn-sm">Revert Change</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection