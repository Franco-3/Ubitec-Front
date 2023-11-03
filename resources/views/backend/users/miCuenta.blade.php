@extends('backend.layouts.main')
@section('title', 'Mi cuenta')
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8 col-xxl-6">
            <div class="p-4 border border-primary rounded bg-light">
                <form action="{{ route('miCuenta.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form__group field mb-2">
                      <input name="nombre" type="input" value="{{ $user->name }}" class="form__field">
                      <label for="nombre" class="form__label">Nombre:</label>
                    </div>

                    <div class="form__group field mb-2">
                      <input name="apellido" type="input" value="{{ $user->lastName }}" class="form__field">
                      <label for="apellido" class="form__label">Apellido:</label>
                    </div>

                    <div class="form__group field mb-2">
                      <input name="telefono" type="input" value="{{ $user->telefono }}" class="form__field">
                      <label for="telefono" class="form__label">Teléfono:</label>
                    </div>

                    <div class="form__group field mb-2">
                      <input name="email" type="input" value="{{ $user->email }}" class="form__field">
                      <label for="email" class="form__label">Email:</label>
                    </div>

                    <div class="form__group field mb-2">
                      <input name="empresa" type="input" value="{{ $user->empresa }}" disabled class="form__field">
                      <label for="nombre" class="form__label">Empresa:</label>
                    </div>
                    <br>
                    <input class="button3" type="submit" value="Guardar">
                     <!-- Button trigger modal -->
                     <button type="button" class="btn btn-danger p-2 fw-semibold text-uppercase float-end rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Cambiar contraseña
                    </button>
                </form>
                <br>
            </div>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar contraseña</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('miCuenta.password', $user->id)}}" method="POST" id="form-pass">
            @csrf
            @method('PATCH')
            <label for="contraseñaActual">Contraseña Actual:</label>
            <input type="password" name="contraseñaActual" class="mb-3">

            <label for="contraseñaNueva">Contraseña Nueva:</label>
            <input type="password" name="contraseñaNueva" class="mb-3">

            <label for="repContraseñaNueva">Repetir Contraseña Nueva:</label>
            <input type="password" name="repContraseñaNueva" class="mb-3">

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button form="form-pass" type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

@endsection