@extends('backend.layouts.main')

@section('content')
<div class="container">
    <br>
    <h2>Editar direccion</h2>
    <form method="POST" action="{{ route('direcciones.update', $direccion->idDireccion) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Direccion:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $direccion->direccion }}">
        </div><br>
        <div class="form-group">
            <label for="descripcion">Latitud:</label>
            <textarea class="form-control" id="latitud" name="latitud">{{ $direccion->latitud }}</textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Longitud:</label>
            <textarea class="form-control" id="longitud" name="longitud">{{ $direccion->longitud }}</textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Tipo:</label>
            <textarea class="form-control" id="tipo" name="tipo">{{ $direccion->tipo }}</textarea>
        </div><br>
        <div class="form-group">
            <label for="precio">Orden:</label>
            <textarea class="form-control" id="orden" name="orden">{{ $direccion->orden }}</textarea>
        </div><br>
        <button type="submit" class="btn btn-primary">Actualizar</button><br><br>
    </form>
</div>
@endsection
