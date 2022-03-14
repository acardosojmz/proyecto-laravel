@extends('plantilla')
@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Editar Candidato
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('candidato.update', $candidato->id) }}"
        enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group">
                <label for="nombrecompleto">Nombre completo:</label>
                <input type="text" id="nombrecompleto"
                 value="{{$candidato->nombrecompleto}}"
                 class="form-control" name="nombrecompleto" />
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>

                <select name="sexo" value="{{$candidato->sexo}}" >
                    @php
                        $selectedSexoH = $candidato->sexo =="H"?" selected ": "";
                        $selectedSexoM = $candidato->sexo =="M"?" selected ": "";
                    @endphp
                    <option {{$selectedSexoH}} value="H">Hombre</option>
                    <option {{$selectedSexoM}} value="M">Mujer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto:</label>
                <img src="/image/{{$candidato->foto}}" height="100px"  width="100px" >
                <input type="file" id="foto" accept="image/png, image/jpeg" 
                 class="form-control" name="foto" />
            </div>
            <div class="form-group">
                <label for="perfil">Perfil:</label>
                <input type="file" id="perfil" accept="application/pdf"
                 class="form-control" name="perfil" />
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@endsection