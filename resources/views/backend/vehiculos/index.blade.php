@extends('backend.layouts.main')
@section('title', __('categorias.index'))
@section('content')
<div class="container text-center mt-2 mb-2">
    <a class="btn btn-success" href="{{ route('vehiculos.create') }}"> <b class="text-dark">Registrar vehiculo nuevo</b>
                            <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                        </a>
</div>
                        
@forelse($vehiculos as $vehiculo)

  
    <div class="col">
    <div class="card">
            <div class="card-body">
            <div class="col">
                <h4 class="card-title text-info">{{ $vehiculo->nombre }}</h4>
            </div>
            <div class="col">
                <p class="card-text">{!! Str::limit($vehiculo->patente, 50) !!}</p>
            </div>
                    <div class="col">
                        <div class="text-end">
                            {{ Form::model($vehiculo, ['method' => 'delete', 'route' => ['vehiculos.destroy', $vehiculo->idVehiculo]]) }}
                            @csrf
                            <a href="{{ route('vehiculos.show', ['vehiculo' => $vehiculo->idVehiculo]) }}" class="btn btn-info"><img src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Mostrar" title="Mostrar"></a>
                            <a href="{{ route('vehiculos.edit', ['vehiculo' => $vehiculo->idVehiculo]) }}" class="btn btn-primary"><img src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar"></a>
                            <button type="submit" class="btn btn-danger" onclick="if (!confirm('Está seguro de borrar la categoria?')) return false;"><img src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar" title="Borrar"></button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                
            </div>
        </div>
    </div>

@empty
<p class="text-capitalize"> No hay vehiculos registrados </p>
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
    