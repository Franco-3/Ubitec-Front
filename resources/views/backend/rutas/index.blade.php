@extends('backend.layouts.main')
@section('title', 'Ubitec - Rutas')
@section('menu')
@parent
<li class="nav-item m-5"><a href="{{ url('/historial') }}" class="nav-link">Historial</a></li>
@endsection
@section('content')



<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <form action="{{route('direcciones.store')}}" method="post" >
                    @csrf
						@if (is_null(session('inicio')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de comienzo">
									<input type="hidden" value="inicio" name="tipo">
								</div>
								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div>
							</div>
						@elseif(is_null(session('final')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de final">
									<input type="hidden" value="final" name="tipo">
								</div>
								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div>
							</div>
						@else
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese la direccion a agregar">
									<input type="hidden" value="normal" name="tipo">
								</div>
								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div>
							</div>
						@endif

				</form>
        </div>
    </div>

	<!-- mostrar direcciones de inicio y final  ToDo: hay que agregar los botones para modificarlas -->
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-title">Direccion inicio:</div>
					@if (Session::has('inicio'))
						<div> {{ session('inicio')->direccion }}</div>
					@endif
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-title">Direccion final:</div>
					@if (Session::has('final'))
						<div> {{ session('final')->direccion }}</div>
					@endif
				</div>
			</div>
		</div>
		
		
	</div>

            <!-- Mapa desplegable -->
            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Abrir Mapa <i class="bi bi-globe-americas"></i></button>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Mapa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="container">
                        <div style="height: 600px; width:600px;" id="map"></div>
                    </div>
                </div>
            </div>
            <!-- Mapa desplegable -->
			<div class="map-table" name="map"></div>


			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI&callback=initMap&v=weekly" async defer></script>

</div>

<div class="container">
	<table class="table table-striped table-dark">
	<thead>
		<tr>
		<th scope="col">#</th>
		<th scope="col">Dirección</th>
		<th scope="col">N° de Paquete</th>
		<th scope="col">Estado</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($direcciones as $indice => $direccion)
			<tr>
				<th scope="row">{{ $indice + 1 }}</th>
				<td>{{$direccion->direccion}}</td>
				<td>sin definir</td>
				<td>no hay campo aun en BD</td>
			</tr>
		@endforeach


	</tbody>
	</table>
</div>

<a href="{{ route('rutas.create') }}">nueva ruta</a>

@endsection
