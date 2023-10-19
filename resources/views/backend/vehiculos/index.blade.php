@extends('backend.layouts.main')
@section('title', __('categorias.index'))
@section('content')
<div class="container text-center mt-2 mb-2">
    <a class="button2" href="{{ route('vehiculos.create') }}">
        <span>
            <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#FFFFFF" height="24" width="24" viewBox="0 0 24 24">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg> Registrar vehiculo nuevo
        </span>
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
