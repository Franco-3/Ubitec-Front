@extends('backend.layouts.main')
@section('title', __('categorias.index'))
@section('content')
<div class="container text-center mt-2 mb-2">
    <a class="btn btn-outline-primary border border-primary border-3" href="{{ route('vehiculos.create') }}"> <b class="text-dark">Registrar vehiculo nuevo</b>
                            <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                        </a>
</div>

@forelse($vehiculos as $vehiculo)

<div class="row m-3">
    <div class="col-md-4">
    <div class="card">

            <div class="card-body">

                <h4 class="card-title text-info">{{ $vehiculo->nombre }}</h4>

            <div class="col">
                <p class="card-text">{!! Str::limit($vehiculo->patente, 50) !!}</p>
            </div>
                    <div class="col">
                        <div class="text-end">
                            {{ Form::model($vehiculo, ['method' => 'delete', 'route' => ['vehiculos.destroy', $vehiculo->idVehiculo]]) }}
                            @csrf
                            <a href="{{ route('vehiculos.show', ['vehiculo' => $vehiculo->idVehiculo]) }}" class="btn btn-info"><i class="bi bi-eye" style="color: white"></i></a>
                            <a href="{{ route('vehiculos.edit', ['vehiculo' => $vehiculo->idVehiculo]) }}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                            <button type="submit" class="btn btn-danger" onclick="if (!confirm('Está seguro de borrar la categoria?')) return false;"><i class="bi bi-trash3"></i></button>
                            {!! Form::close() !!}
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@empty
<p class="text-center text-capitalize"> No hay vehiculos registrados </p>
@endforelse
</div>
<hr>
<!-- Paginación -->
<div class="d-flex justify-content-center">
    <!--
  Agregar en App\Providers\AppServiceProvider:
  use Illuminate\Pagination\Paginator;
      public function boot() { Paginator::useBootstrap(); } -->


</div>
@endsection
