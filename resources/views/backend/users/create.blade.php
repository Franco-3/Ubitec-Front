@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
    <h1>Nuevo Usuario</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::open(['route' => 'users.store', 'files' => true]) }}
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </ul>
            </div>
        @endif
        <div class="form-group">
            {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) }}
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
            {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ingrese el email']) }}
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese el password']) }}
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password_confirm', 'Confirmar Password', ['class' => 'control-label']) }}
            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Ingrese el password']) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Tipo de usuario', ['class' => 'control-label']) }}
            {{ Form::select('type', [0 =>'Normal', 1=>'Administrador'], null, ['class' => 'form-control']) }}
            @error('categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button>
    </div>
    {!! Form::close() !!}
@endsection
