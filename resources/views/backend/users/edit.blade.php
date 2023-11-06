@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center mb-4"><svg width="100px" height="100px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-person-badge"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path> <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"></path> </g></svg></h1>
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
                    <div class="coolinput mb-3">
                        {{ Form::label('name', 'Nombre', ['class' => 'control-label text']) }}
                        {{ Form::text('name', old('name'), ['class' => 'form-control input', 'placeholder' => 'Ingrese el nombre']) }}
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="coolinput mb-3">
                        {{ Form::label('email', 'Email', ['class' => 'control-label text']) }}
                        {{ Form::text('email', old('email'), ['class' => 'form-control input', 'placeholder' => 'Ingrese el email', 'readonly']) }}
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="coolinput mb-3">
                        {{ Form::label('password', 'Password', ['class' => 'control-label text']) }}
                        {{ Form::password('password', ['class' => 'form-control input', 'placeholder' => 'Ingrese el password']) }}
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="coolinput mb-3">
                        {{ Form::label('password-confirm', 'Confirmar Password', ['class' => 'control-label text']) }}
                        {{ Form::password('password_confirmation', ['class' => 'form-control input', 'placeholder' => 'Confirme el password']) }}
                    </div>
                    <div class="coolinput mb-3">
                        {{ Form::label('tipo', 'Tipo de usuario', ['class' => 'control-label text']) }}
                        {{ Form::select('tipo', [0 => 'Administrador', 1 => 'Basico'], null, ['class' => 'form-control input', 'placeholder' => 'Seleccione el tipo de usuario']) }}
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary my-1">Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
