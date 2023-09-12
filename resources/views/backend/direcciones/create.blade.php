@extends('backend.layouts.main')

@section('content')
<div class="container">
    <br>
    <h2>Crear direccion</h2><br>
    <form method="POST" action="{{ route('direcciones.store') }}">
        @csrf
        <div class="form-group">
            <label for="nombre">Direccion:</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div><br>
        <div class="form-group">
            <label for="descripcion">Latitud:</label>
            <textarea class="form-control" id="latitud" name="latitud"></textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Longitud:</label>
            <textarea class="form-control" id="longitud" name="longitud"></textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Tipo:</label>
            <textarea class="form-control" id="tipo" name="tipo"></textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Orden:</label>
            <textarea class="form-control" id="orden" name="orden"></textarea>
        </div><br>
        <button type="submit" class="btn btn-primary">Guardar</button><br><br>
    </form>
</div>
@endsection
