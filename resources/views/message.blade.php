@extends('plantilla')
@section('content')
<div 
    class="d-flex align-items-center justify-content-center">
    <div class="card card-block text-center align-middle w-30">
        <div class="card-header">
            MENSAJE
        </div>
        <div class="card-body">
            @if($success)
            <div class="alert alert-success">
                <h1> {{ $message }} </h1>
            </div>

            @else
            <div class="alert alert-danger">
                <h1>{{ $message }} </h1>
            </div>
            @endif
        </div>
        <div class="card-body">
            <button type="button" onclick="history.back();" class="btn btn-primary">Regresar</button>
        </div>
    </div>
</div>    
@endsection