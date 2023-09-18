@extends('backend.layouts.main')
@section('title', 'Administrador')
@section('content')

    <a href="" class="btn-btn primary">Agrgar vehiculo</a>
    <a href="" class="btn-btn primary">Agrgar Usuario</a>

    <div class="container">
        <table class="table table-striped table-dark">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">vehiculo</th>
            <th scope="col">N° de patente</th>
            <th scope="col">Usuario</th>
            <th scope="col">Cant direcciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $indice = 0 ?>
            @foreach ($vehiculosUsuario as  $vUsuario)
                <?php $indice++ ?>
                <tr>
                    <th scope="row">{{$indice}}</th>
                    <td>{{$vUsuario->nombre}}</td>
                    <td>{{$vUsuario->patente}}</td>
                    <td>{{$vUsuario->name}}</td>
                    <td></td>
{{--                     @if (!empty($direccion->idDireccion))
                        <td>
                            <form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    @endif --}}
                </tr>
            @endforeach


        </tbody>
        </table>
    </div>

@endsection
