@extends('backend.layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center border-bottom border-primary mb-4">Editar dirección</h1>

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
