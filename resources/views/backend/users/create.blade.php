@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center border-bottom  border-primary mb-4">Nuevo Usuario</h1>
                <div>
                    @if (Session::has('status'))
                        <div class="alert alert-success">{{ Session('status') }}</div>
                    @endif
                </div>
                <div class="links">
                    {{ Form::open(['route' => 'users.store']) }}
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
                    <div class="form-group mb-3">
                        {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) }}
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ingrese el email']) }}
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese el password']) }}
                        </div>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('password_confirm', 'Confirmar Password', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Ingrese el password']) }}
                        </div>
                    </div>
                    <div class="form-groupmb-3">
                        {{ Form::label('tipo', 'Tipo de usuario', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill-gear"></i></span>
                            {{ Form::select('tipo', [1 =>'Normal', 0=>'Administrador'], null, ['class' => 'form-control']) }}
                        </div>
                        @error('tipo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <br>
                        <button type="submit" class="button3">
                            <span>
                                Guardar
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="#ffffff" d="M20.33 3.66996C20.1408 3.48213 19.9035 3.35008 19.6442 3.28833C19.3849 3.22659 19.1135 3.23753 18.86 3.31996L4.23 8.19996C3.95867 8.28593 3.71891 8.45039 3.54099 8.67255C3.36307 8.89471 3.25498 9.16462 3.23037 9.44818C3.20576 9.73174 3.26573 10.0162 3.40271 10.2657C3.5397 10.5152 3.74754 10.7185 4 10.85L10.07 13.85L13.07 19.94C13.1906 20.1783 13.3751 20.3785 13.6029 20.518C13.8307 20.6575 14.0929 20.7309 14.36 20.73H14.46C14.7461 20.7089 15.0192 20.6023 15.2439 20.4239C15.4686 20.2456 15.6345 20.0038 15.72 19.73L20.67 5.13996C20.7584 4.88789 20.7734 4.6159 20.7132 4.35565C20.653 4.09541 20.5201 3.85762 20.33 3.66996ZM4.85 9.57996L17.62 5.31996L10.53 12.41L4.85 9.57996ZM14.43 19.15L11.59 13.47L18.68 6.37996L14.43 19.15Z"></path> </g></svg>
                              </span>
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
