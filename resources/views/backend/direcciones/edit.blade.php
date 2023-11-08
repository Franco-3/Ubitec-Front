@extends('backend.layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
            <h2 class=" text-center mb-4"><svg fill="#000000" width="100px" height="100px" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg svg-white"><path d="M15.084 15.2H.916a.264.264 0 0 1-.254-.42l2.36-4.492a.865.865 0 0 1 .696-.42h.827a9.51 9.51 0 0 0 .943 1.108H3.912l-1.637 3.116h11.45l-1.637-3.116h-1.34a9.481 9.481 0 0 0 .943-1.109h.591a.866.866 0 0 1 .696.421l2.36 4.492a.264.264 0 0 1-.254.42zM11.4 7.189c0 2.64-2.176 2.888-3.103 5.46a.182.182 0 0 1-.356 0c-.928-2.572-3.104-2.82-3.104-5.46a3.282 3.282 0 0 1 6.563 0zm-1.86-.005a1.425 1.425 0 1 0-1.425 1.425A1.425 1.425 0 0 0 9.54 7.184z"/></svg></h2>

                <form method="POST" action="{{ route('direcciones.update', $direccion->idDireccion) }}">
                    @csrf
                    @method('PUT')

                    <div class="coolinput mb-3">
                        <label for="direccion" class="text">Dirección:</label>
                        <input type="text" class="input" id="direccion" name="direccion" value="{{ $direccion->direccion }}">
                    </div>

                    <div class="coolinput mb-3">
                        <label for="latitud" class="text">Latitud:</label>
                        <textarea class="input" id="latitud" name="latitud">{{ $direccion->latitud }}</textarea>
                    </div>

                    <div class="coolinput mb-3">
                        <label for="longitud" class="text">Longitud:</label>
                        <textarea class="input" id="longitud" name="longitud">{{ $direccion->longitud }}</textarea>
                    </div>

                    <div class="coolinput mb-3">
                        <label for="tipo" class="text">Tipo:</label>
                        <textarea class="input" id="tipo" name="tipo">{{ $direccion->tipo }}</textarea>
                    </div>

                    <div class="coolinput mb-3">
                        <label for="orden" class="text">Orden:</label>
                        <textarea class="input" id="orden" name="orden">{{ $direccion->orden }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection
