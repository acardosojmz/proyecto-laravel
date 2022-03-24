@extends('plantilla')
@section('content')
<div class="card uper">
    <div class="card-header">
        MENSAJE
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <h1>{{$message}}</h1>
        </div><br />   
    </div>
    <div class="card-body">
    <button type="button"
    onclick="history.back();"
     class="btn btn-primary">Regresar</button>  
    </div>
</div>
@endsection