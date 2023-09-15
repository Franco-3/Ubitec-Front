@extends('backend.layouts.main')
@section('title', 'Ubitec - Historial')
@section('content')
<style>
    @media (min-width:400px){
    .section-content{
      min-height: calc(100vh - 350px);
    }
}
</style>


<div class="container mt-2 section-content">
    <div class="row d-flex justify-content-around align-items-center">
        @foreach ($rutas as $ruta)
            <div class="col mb-2">
                <div class="card" style="width: 18rem;">
                    <img src="https://phantom-elmundo.unidadeditorial.es/f63778a06bcec91b6ca42723ad6aa9e5/crop/168x72/1032x648/f/jpg/assets/multimedia/imagenes/2021/08/26/16299752237253.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">
                            Comienzo: {{ $ruta->direccion_inicio}}
                        </p>

                        <p>Final: {{ $ruta->direccion_final }}</p>
                        <a href="{{route ('historial.show', ['historial' => $ruta->idRuta])}}" class="btn btn-primary">Importar Ruta</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
