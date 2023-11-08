@extends('backend.layouts.main')

@section('title', 'Nuevo Vehiculo')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border border-primary rounded">
<h1 class="h1 text-center mb-4"><svg fill="#000000" width="100px" height="100px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="svg-white"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M2.84375 13C1.285156 13 0 14.285156 0 15.84375L0 42C0 43.660156 1.339844 45 3 45L7.09375 45C7.570313 47.835938 10.035156 50 13 50C15.964844 50 18.429688 47.835938 18.90625 45L28.15625 45C28.894531 45 29.554688 44.6875 30.0625 44.21875C30.582031 44.675781 31.246094 44.992188 32 45L33.09375 45C33.570313 47.835938 36.035156 50 39 50C42.300781 50 45 47.300781 45 44C45 40.699219 42.300781 38 39 38C36.035156 38 33.570313 40.164063 33.09375 43L32 43C31.8125 43 31.527344 42.871094 31.3125 42.65625C31.097656 42.441406 31 42.183594 31 42L31 23C31 22.625 31.625 22 32 22L40 22C40.785156 22 41.890625 22.839844 42.65625 23.75C42.664063 23.761719 42.679688 23.769531 42.6875 23.78125L42.84375 24L38 24C36.40625 24 35 25.289063 35 27L35 31C35 31.832031 35.375 32.5625 35.90625 33.09375C36.4375 33.625 37.167969 34 38 34L48 34L48 42C48 42.375 47.375 43 47 43L45 43L45 45L47 45C48.660156 45 50 43.660156 50 42L50 32.375C50 30.085938 48.40625 28.0625 48.40625 28.0625L48.375 28.0625L44.25 22.5625L44.25 22.53125L44.21875 22.5C43.296875 21.386719 41.914063 20 40 20L32 20C31.644531 20 31.316406 20.074219 31 20.1875L31 15.90625C31 14.371094 29.789063 13 28.1875 13 Z M 2.84375 15L28.1875 15C28.617188 15 29 15.414063 29 15.90625L29 42.15625C29 42.625 28.628906 43 28.15625 43L18.90625 43C18.429688 40.164063 15.964844 38 13 38C10.035156 38 7.570313 40.164063 7.09375 43L3 43C2.625 43 2 42.371094 2 42L2 15.84375C2 15.375 2.367188 15 2.84375 15 Z M 38 26L44.34375 26L46.78125 29.25C46.78125 29.25 47.6875 30.800781 47.875 32L38 32C37.832031 32 37.5625 31.875 37.34375 31.65625C37.125 31.4375 37 31.167969 37 31L37 27C37 26.496094 37.59375 26 38 26 Z M 13 40C15.222656 40 17 41.777344 17 44C17 46.222656 15.222656 48 13 48C10.777344 48 9 46.222656 9 44C9 41.777344 10.777344 40 13 40 Z M 39 40C41.222656 40 43 41.777344 43 44C43 46.222656 41.222656 48 39 48C36.777344 48 35 46.222656 35 44C35 41.777344 36.777344 40 39 40Z"></path></g></svg></h1>

                <div>
                    @if (Session::has('status'))
                        <div class="alert alert-success">{{ Session('status') }}</div>
                    @endif
                </div>

                <div class="links">
                    {{ Form::open(['route' => 'vehiculos.store']) }}
                    @csrf

                    <div class="coolinput mb-3 @if ($errors->has('titulo')) has-error has-feedback @endif">
                        {{ Form::label('name', 'Nombre', ['class' => 'control-label text']) }}
                        {{ Form::text('name', old('name'), ['class' => 'form-control input', 'placeholder' => 'Ingrese el nombre']) }}
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="coolinput mb-3">
                        {{ Form::label('patente', 'Patente', ['class' => 'control-label text']) }}
                        {{ Form::text('patente', old('patente'), ['class' => 'form-control input', 'placeholder' => 'Ingrese la patente', 'maxLength' => '7']) }}
                        @error('patente')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="coolinput mb-3">
                        {{ Form::label('usuario', 'Usuario', ['class' => 'control-label text']) }}
                        {{ Form::select('usuario', $users->pluck('email', 'id'), null, ['class' => 'form-control input']) }}
                        @error('usuario')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection
