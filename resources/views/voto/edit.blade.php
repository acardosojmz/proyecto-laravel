@extends('plantilla')
@section('content')

<div>
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    <br />
    @endif
</div>
<form action="{{ route('voto.update', $voto->id)}}"
    method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <input type="hidden" 
            name="eleccion_id" 
            value="{{$voto->eleccion_id}}"
        />
        <label for="eleccion">Eleción:</label>
        <input type="text" id="eleccion" 
            value="{{$voto->eleccion->periodo}}"
            readonly/>
    </div>
    <div class="form-group">
        <input type="hidden" 
            name="casilla_id" 
            value="{{$voto->casilla_id}}"
        />
        <label for="casilla">Casilla:</label>
        <input type="text" id="casilla" 
            value="{{$voto->casilla->ubicacion}}"
            readonly/>        
    </div>
    <hr></hr>
    <div class="form-group">
        <table class="table">
            @foreach($voto->candidatos as $candidato)
                <tr>
                    <td>{{$candidato->nombrecompleto}} </td>
                    <td><input type="text" 
                    value="{{$candidato->pivot->votos}}"
                    name="candidato_{{$candidato->id}}"  > </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="form-group">
        <label for="evidencia">Evidencia:</label>
        <input type="file" id="evidencia" 
            accept="application/pdf"
            class="form-control" name="evidencia" />
    </div>

    <button class="btn btn-primary"
     type="submit">Guardar cambios</button>


</form>

@endsection