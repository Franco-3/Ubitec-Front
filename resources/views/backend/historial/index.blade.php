@extends('backend.layouts.main')
@section('title', 'Ubitec - Historial')
@section('content')

<div class="container mt-4 section-content">
    <div class="row d-flex justify-content-around align-items-center">
        @foreach ($rutas as $ruta)
            <div class="col mb-2">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset($ruta->path) }}" class="card-img-top" alt="Captura de la ruta">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">
                            <strong>Comienzo:</strong> {{ $ruta->direccion_inicio}}
                        </p>

                        <p><strong>Final:</strong> {{ $ruta->direccion_final }}</p>
                        <a href="{{ route('historial.show', ['historial' => $ruta->idRuta]) }}" class="button2">
                            <span>
                                <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="currentColor" height="20" width="20" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line y2="13" x2="8" y1="13" x1="16"></line>
                                    <line y2="17" x2="8" y1="17" x1="16"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg> Importar Ruta
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Mostrar la paginaciÃ³n -->
    <div class="d-flex justify-content-center mt-4">
        {{ $rutas->links() }}
    </div>
</div>

@endsection