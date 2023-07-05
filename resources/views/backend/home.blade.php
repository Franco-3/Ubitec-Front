@extends('backend.layouts.main')
@section('title', 'UBITEC')

@section('content')
<style>
    .main-bg{
        width:100%;
        filter: brightness(40%);
    }

.img1 .container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  color: white;
  font-size: 16px;
  padding: 12px 24px;
  border: none;
  text-align: center;
  background-color: rgba(255, 255, 255, 0);
}
</style>

<div class="img1">
    <img src="img/home_bg.png" class="img-fluid main-bg" alt="image">
    <div class="container">
        <div class="card-sm-2 text-center">
            <div class="card-body">
                <h3 class="card-title m-3" style="text-shadow: #080404;">Soluciones de logistica</h3>
                <a href="/login" class="btn btn-success m-2">Entrar</a>
                <a href="/register" class="btn btn-success m-2">Registarse</a>
            </div>
        </div>
    </div>
</div>

<div class="jumbotron">
    <div class="container mb-3">
        <div class="card mt-3 text-center">
            <div class="card-body">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Quienes somos</h5>
                        <p class="card-text">UBITEC es una empresa dedicada a prestar servicios para facilitar el recorrido de rutas a transportistas, repartidores y la industria de la logistica.</p>
                    </div>
                </div>

                <div class="card mt-3">
                <div class="card-body">
                        <h5 class="card-title">A quienes nos dirigimos</h5>
                        <p class="card-text">Nuestro servicio es uno de los mas rapidos y mejores del mercado, ofreciendo una solucion eficaz para empresas de pequeño y gran tamaño.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection


