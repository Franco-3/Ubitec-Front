@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
<div class="container mt-5 mb-5 p-4 border border-black rounded">
    <h1 class="h1 text-center border-bottom mb-4">Editar Usuario</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::model($user, ['method' => 'put', 'route' => ['users.update', $user->id], 'files' => true]) }}
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
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></i></i></span>
                {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) }}
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ingrese el email', 'readonly']) }}
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese el password']) }}
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password-confirm', 'Confirmar Password', ['class' => 'control-label']) }}
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirme el password']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('tipo', 'Tipo de usuario', ['class' => 'control-label']) }}
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill-gear"></i></span>
                {{ Form::select('tipo',[0 =>'Administrador', 1 =>'Basico'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione el tipo de usuario']) }}
            </div>
        </div>
        </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection
