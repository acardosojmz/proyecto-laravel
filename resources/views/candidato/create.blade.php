@extends('plantilla')
@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Agregar Candidato
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
        <form method="post" 
            action="{{ route('candidato.store') }} " 
            enctype="multipart/form-data"
            onsubmit="return validateData();">
            <!-- comment -->
            {{ csrf_field() }}
            <div class="form-group">
                <label for="nombrecompleto">Nombre completo:</label>
                <input type="text" id="nombrecompleto"
                 class="form-control" name="nombrecompleto" />
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select name="sexo">
                    <option value="H">Hombre</option>
                    <option value="M">Mujer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" accept="image/png, image/jpeg" 
                 class="form-control" name="foto" 
                 onchange="previewImage(event,'imageCandidato');"
                  />
                  <img src="" id="imageCandidato" width="200px" heigth="200px">
            </div>
            <div class="form-group">
                <label for="perfil">Perfil:</label>
                <input type="file" id="perfil" accept="application/pdf"
                 class="form-control" name="perfil"   
                 onchange="previewPDF(event, 'previewPDF' );" />
                  
            </div>
            <iframe id="previewPDF" style="display:none;" title="preview"></iframe>
            
            <button type="submit" 
            class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
<script type="text/javascript" 
src="{{ URL::asset('js/custom.js') }}">
</script>
@endsection
