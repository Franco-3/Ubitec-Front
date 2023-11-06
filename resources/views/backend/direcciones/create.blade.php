@extends('backend.layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center border-bottom border-primary mb-4">Crear dirección</h1>

                <form method="POST" action="{{ route('direcciones.store') }}">
                    @csrf

                    <div class="coolinput mb-3">
                        <label for="direccion" class="text">Direccion:</label>
                        <input type="text" class="input" id="direccion" name="direccion">
                    </div><br>

                    <div class="coolinput mb-3">
                        <label for="latitud" class="text">Latitud:</label>
                        <textarea class="input" id="latitud" name="latitud"></textarea>
                    </div><br>

                    <div class="coolinput mb-3">
                        <label for="longitud" class="text">Longitud:</label>
                        <textarea class="input" id="longitud" name="longitud"></textarea>
                    </div><br>

                    <div class="coolinput mb-3">
                        <label for="tipo" class="text">Tipo:</label>
                        <textarea class="input" id="tipo" name="tipo"></textarea>
                    </div><br>

                    <div class="coolinput mb-3">
                        <label for="orden" class="text">Orden:</label>
                        <textarea class="input" id="orden" name="orden"></textarea>
                    </div><br>

                    <button type="submit" class="btn btn-primary my-1">Guardar</button><br><br>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
