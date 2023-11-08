@extends('backend.layouts.main')
@section('title', __('Ubitec - Vehiculos'))
@section('content')
<div class="container text-center mt-2 mb-2">
    <a class="button2" href="{{ route('vehiculos.create') }}">
        <span>
            <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#FFFFFF" height="24" width="24" viewBox="0 0 24 24">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg> Registrar vehiculo nuevo
    </a>

</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar vehiculo a usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form id="form" action="" method="PUT">
                @csrf
                @method('PUT')
                <div class="form-group">
                    {{ Form::label('patente', 'Patente', ['class' => 'control-label']) }}<br>
                    {{ Form::input('patente', '', null, ['class' => 'form-control', 'readonly', 'id' => 'patente']) }}
                    @error('patente')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::label('nombre', 'Vehiculo', ['class' => 'control-label']) }}<br>
                    {{ Form::input('nombre', '', null, ['class' => 'form-control', 'readonly', 'id' => 'nombre']) }}
                    @error('nombre')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::label('usuario', 'Usuario Asignado', ['class' => 'control-label']) }}
                    {{ Form::select('usuario', $users, null, ['class' => 'form-control', 'id' => 'usuario', 'placeholder' => 'Selecciona un usuario']) }}
                    @error('usuario')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mt-2">
                    <label class="form-check-label" for="flexCheckDefault">
                        No asignar usuario
                    </label>
                        <input name="nouser" class="form-check-input" type="checkbox" id="nouser" value="nouser">
                </div>

                <div class="form-group">
                    {{ Form::input('id', '', null, ['class' => 'invisible', 'readonly', 'id' => 'id']) }}
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

                <!-- </br><button type="submit"  id="editForm" style="width: 100%;" class="btn btn-primary update">Guardar</button> -->
            </form>
        </div>

      </div>
     </div>
  </div>
<!-- Fin Modal -->


<div class="container">
    @if($vehiculos->isEmpty())
        <div class="alert alert-primary text-center" role="alert">
            No hay vehículos.
        </div>
    @else
        <table id="index" class="table table-striped dt-responsive" style="width: 100%">
            <thead>
                <tr>
                    <th>Patente</th>
                    <th>Nombre</th>
                    <th class="text-center">Usuario Asignado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->patente }}</td>
                        <td>{{ $vehiculo->nombre }}</td>
                        <td class="text-center">
                            @if($vehiculo->idUsuario != null)
                                {{ $vehiculo->asignadoA->name . ' ' . $vehiculo->asignadoA->lastName }}
                            @else
                                Sin asignar
                            @endif
                        </td>
                        <td>
                            {{ Form::model($vehiculo, ['method' => 'delete', 'route' => ['vehiculos.destroy', $vehiculo->idVehiculo]]) }}
                            @csrf
                                <!-- Botón para abrir modal -->
                                <button type="button" class="btn btn-info edit my-1" data-id='{{ $vehiculo->idVehiculo }}' data-patente='{{ $vehiculo->patente }}' data-nombre='{{ $vehiculo->nombre }}' data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="top" title="Cambiar usuario">
                                    <span>
                                        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#FFFFFF" height="15" width="15" viewBox="0 0 24 24">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </span>
                                </button>
                                <!-- ... (código del botón) ... -->
                                <a href="{{ route('vehiculos.edit', ['vehiculo' => $vehiculo->idVehiculo]) }}" class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                <button type="submit" class="btn btn-danger" onclick="if (!confirm('¿Estás seguro de borrar el Vehículo?')) return false;" data-toggle="tooltip" data-placement="top" title="Borrar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

    <script>
        $(document).ready(function () {

            $(document).on('click', '.edit', function(event){
                    var id = $(this).data('id');
                    var patente = $(this).data('patente');
                    var nombre = $(this).data('nombre');
                    $('#patente').val(patente);
                    $('#nombre').val(nombre);
                    $('#id').val(id);
                    var action = 'http://ubitec-front.test/vehiculos/updateUser/' + id;
                    var formulario = $('#form');
                    formulario.attr('action', action);
            });

        });
    </script>

@endsection
