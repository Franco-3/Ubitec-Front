@extends('backend.layouts.main')

@section('title', 'Editar Categoria')

@section('content')
    <h1>Editar Vehiculo</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::model($vehiculo, ['method' => 'put', 'route' => ['vehiculos.update', $vehiculo->idVehiculo]]) }}
        @csrf
        <div class="form-group @if ($errors->has('titulo')) has-error has-feedback @endif">
            {{ Form::label('name', 'Título', ['class' => 'control-label']) }}
            {{ Form::text('name', $vehiculo->nombre, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) }}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('patente', 'Patente', ['class' => 'control-label']) }}
            {{ Form::text('patente', $vehiculo->patente, ['class' => 'form-control', 'readonly']) }}
            @error('patente')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('usuario', 'Usuario asignado', ['class' => 'control-label']) }}
            {{ Form::text('usuario', '-', ['class' => 'form-control', 'readonly']) }}
            @error('usuario')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
    </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button>
    </div>
    {!! Form::close() !!}
@endsection
