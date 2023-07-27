@extends('backend.layouts.main')

@section('title', 'Nuevo Vehiculo')

@section('content')
    <h1>Nueva Vehiculo</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::open(['route' => 'vehiculos.store']) }}
        @csrf
        <div class="form-group @if ($errors->has('titulo')) has-error has-feedback @endif">
            {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) }}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('patente', 'Patente', ['class' => 'control-label']) }}
            {{ Form::text('patente', old('patente'), ['class' => 'form-control', 'placeholder' => 'Ingrese la patente', 'maxLength' => '7']) }}
            @error('patente')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('usuario', 'Usuario', ['class' => 'control-label']) }}
            {{ Form::text('usuario', '-', ['class' => 'form-control', 'placeholder' => 'Ingrese la usuario', 'readonly']) }}
            @error('usuario')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
    </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button></div>
    {!! Form::close() !!}
@endsection