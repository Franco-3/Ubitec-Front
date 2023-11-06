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
            <div class="p-4 border border-primary rounded">
                <h1 class="h1 text-center mb-4"><svg width="100px" height="100px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-person-badge"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path> <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"></path> </g></svg></h1>
                <form action="{{ route('miCuenta.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="coolinput mb-3">
                        <label for="nombre" class="text">Nombre</label>
                      <input name="nombre" type="input" value="{{ $user->name }}" class="form-control input">
                    </div>

                    <div class="coolinput mb-3">
                        <label for="apellido" class="text">Apellido</label>
                      <input name="apellido" type="input" value="{{ $user->lastName }}" class="form-control input">
                    </div>

                    <div class="coolinput mb-3">
                        <label for="telefono" class="text">Teléfono</label>
                      <input name="telefono" type="input" value="{{ $user->telefono }}" class="form-control input">
                    </div>

                    <div class="coolinput mb-3">
                        <label for="email" class="text">Email</label>
                      <input name="email" type="input" value="{{ $user->email }}" class="form-control input">
                    </div>

                    <div class="coolinput mb-3">
                        <label for="empresa" class="text">Empresa</label>
                      <input name="empresa" type="input" value="{{ $user->empresa }}" disabled class="form-control input">
                    </div>
                    <div class="text-end">
                        <input class="btn btn-primary my-1" type="submit" value="Guardar">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                         Cambiar contraseña
                       </button>
                    </div>
                </form>
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
            <div class="form-floating mb-3">
                <input class="form-control" id="contraseñaActual" type="password" name="contraseñaActual">
                <label for="contraseñaActual">Contraseña Actual</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="contraseñaNueva" type="password" name="contraseñaNueva">
                <label for="contraseñaNueva">Contraseña Nueva</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="repContraseñaNueva" type="password" name="repContraseñaNueva">
                <label for="repContraseñaNueva">Repetir Contraseña Nueva</label>
            </div>
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
