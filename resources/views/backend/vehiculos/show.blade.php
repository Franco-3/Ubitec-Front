@extends('backend.layouts.main')
@section('title', 'Vehiculo')
@section('content')
<div class="container mt-5 mb-5 p-4 border border-black rounded">
    <h1 class="h1 text-center border-bottom mb-4">Editar Usuario Asignado</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::model($vehiculo, ['method' => 'put', 'route' => ['vehiculos.update', $vehiculo->idVehiculo]]) }}
        @csrf
        <div class="form-group">
            {{ Form::label('nombre', 'Nombre', ['class' => 'control-label']) }}
            {{ Form::text('nombre', $vehiculo->nombre, ['class' => 'form-control', 'readonly']) }}
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('patente', 'Patente', ['class' => 'control-label']) }}
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-car-front-fill"></i></span>
                {{ Form::text('patente', $vehiculo->patente, ['class' => 'form-control', 'readonly']) }}
            </div>
            @error('patente')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('idUsuario', 'Usuario Asignado', ['class' => 'control-label']) }}
            {{ Form::select('idUsuario', $users, $vehiculo->idUsuario, ['class' => 'form-control']) }}
            @error('idUsuario')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
    </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection
