@extends('backend.layouts.main')

@section('title', 'Usuarios')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center border-bottom border-primary mb-4">Usuarios</h1>

                @if (Session::has('status'))
                <div class="alert alert-success">{{ Session('status') }}</div>
                @endif

                <div class="links">
                    {!! Form::model($user, ['method' => 'get', 'route' => ['users.show', $user->id]]) !!}

                    <div class="form-group mb-3">
                        {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre', 'readonly']) }}
                        </div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ingrese el email', 'readonly']) }}
                        </div>
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('tipo', 'Tipo de usuario', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill-gear"></i></span>
                            {{ Form::text('tipo', old('tipo'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        @error('tipo')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection