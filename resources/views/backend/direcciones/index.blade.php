@extends('backend.layouts.main')
@section('title', __('Ubitec - Direcciones'))
@section('content')
<div class="container">
    <br>
    <h2>Listado de Direcciones</h2>

    <div class="container">
        <table class="table table-striped dt-responsive direcciones-completas" style="width: 100%">
        <thead>
            <tr>
                <th >ID</th>
                <th>Direccion</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Tipo</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acción</th>
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
                <td>{{ $direccion->name }}</td>
                <td class="text-center">
					<label>
						<form>
							<input name='estado' type='checkbox' disabled {{ $direccion->estado ? 'checked' : '' }}>
							<div class='check mx-auto'></div>
						</form>
					</label>
				</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('direcciones.edit', $direccion->idDireccion) }}" class="btn btn-primary mr-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="margin-left: 5px;" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <br><br>

    <div class="container">
        <table class="table table-striped dt-responsive direcciones-incompletas" style="width: 100%">
            <thead>
                <tr>
                    <th >ID</th>
                    <th>Direccion</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Tipo</th>
                    <th>usuario</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($direcciones2 as $direccion2)
                <tr>
                    <td>{{ $direccion2->idDireccion }}</td>
                    <td>{{ $direccion2->direccion }}</td>
                    <td>{{ $direccion2->latitud }}</td>
                    <td>{{ $direccion2->longitud }}</td>
                    <td>{{ $direccion2->tipo }}</td>
                    <td>{{ $direccion2->name }}</td>
                    <td class="text-center">
                        <label>
                            <form>
                                <input name='estado' type='checkbox' disabled {{ $direccion2->estado ? 'checked' : '' }}>
                                <div class='check'></div>
                            </form>
                        </label>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('direcciones.edit', $direccion2->idDireccion) }}" class="btn btn-primary mr-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                            {{ Form::open(['method' => 'delete', 'route' => ['direcciones.destroy', $direccion2->idDireccion]]) }}
                            @csrf
                            <button type="submit" class="btn btn-danger" style="margin-left: 5px;" data-toggle="tooltip" data-placement="top" title="Borrar" onclick="return confirm('¿Está seguro de borrar la dirección?');">
                                <i class="bi bi-trash3"></i>
                            </button>
                            {{ Form::close() }}
                        </div>
                    </td>
    
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
</div>

@endsection
