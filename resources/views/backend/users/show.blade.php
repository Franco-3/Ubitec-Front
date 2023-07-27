@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
    <h1>Usuarios</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::model($user, ['method' => 'get', 'route' => ['users.show', $user->id]]) }}
        <div class="form-group">
            {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre', 'readonly']) }}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
            {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ingrese el email', 'readonly']) }}
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Tipo de usuario', ['class' => 'control-label']) }}
            {{ Form::text('type', 'por definir', ['class' => 'form-control', 'readonly']) }}
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {!! Form::close() !!}
    @endsection
