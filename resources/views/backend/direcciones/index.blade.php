@extends('backend.layouts.main')

@section('content')
<div class="container">
    <br>
    <h2>Listado de Direcciones</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Direccion</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Tipo</th>
                <th>Orden</th>
            </tr>
        </thead>
        <tbody>
            @foreach($direcciones as $direccion)
            <tr>
                <td>{{ $direccion->idDireccion }}</td>
                <td>{{ $direccion->direccion }}</td>
                <td>{{ $direccion->latitud }}</td>
                <td>{{ $direccion->longitud }}</td>
                <td>{{ $direccion->tipo }}</td>
                <td>{{ $direccion->orden }}</td>
                <td>
                    <a href="{{ route('direcciones.edit', $direccion->idDireccion) }}" class="btn btn-primary">Editar</a><br>
                    <form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('direcciones.create') }}" class="btn btn-success">Agregar Producto</a>
    <br><br>
</div>
@endsection