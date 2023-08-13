@extends('backend.layouts.main')
@section('title', 'Ubitec - Rutas')
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
									<input id="tipo" type="hidden" value="inicio" name="tipo">
								</div>
{{-- 								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div> --}}
							</div>
						@elseif(is_null(session('final')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de final">
									<input id="tipo" type="hidden" value="final" name="tipo">
								</div>
{{-- 								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div> --}}
							</div>
						@else
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese la direccion a agregar">
									<input id="tipo" type="hidden" value="normal" name="tipo">
								</div>
{{-- 								<div style="flex: 1; margin-left: 10px;">
									<label for="add_start" class="btn btn-success">
										<i class="bi bi-plus-circle"></i>
									</label>
									<input name="add_start" type="submit" id="add_start" style="display: none;">
								</div> --}}
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
                        <div style="height: 600px; width:600px;" id="map" class="specific"></div>
                    </div>
                </div>
            </div>
            <!-- Mapa desplegable -->
			<div class="map-table" name="map"> </div>


			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			{{-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI&callback=initMap&v=weekly" async defer></script> --}}
			<script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
			<script>
				// Define una variable global de JavaScript con el token CSRF
				window.csrfToken = "{{ csrf_token() }}";
			</script>
			@if (!empty($responseData))
				<script>
					window.responseData = @json($responseData);
				</script>
			@endif

</div>


<button id="exportBtn" onclick="downloadMap();">Экспорт в изображение без заголовка</button>
<div class="container">
	<table class="table table-striped table-dark">
	<thead>
		<tr>
		<th scope="col">#</th>
		<th scope="col">Dirección</th>
		<th scope="col">N° de Paquete</th>
		<th scope="col">Estado</th>
		<th scope="col">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php $indice = 0 ?>
		@foreach ($direcciones as  $direccion)
			<?php $indice++ ?>
			<tr>
				<th scope="row">{{$indice}}</th>
				<td>{{$direccion->direccion}}</td>
				<td>sin definir</td>
				<td>no hay campo aun en BD</td>
				@if (!empty($direccion->idDireccion))
					<td>
						<form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
						</form>
					</td>
				@endif
			</tr>
		@endforeach


	</tbody>
	</table>
</div>

<a href="{{ route('rutas.index') }}">Editar</a> <!-- este boton solo se debe mostrar si las rutas estan ordenadas, es para volver y editarlas -->
<a href="{{ route('rutas.create') }}">nueva ruta</a>
<a href="{{ route('direcciones.ordenar') }}">Ordenar Direcciones</a> <!-- faltan modificaciones de los datos que se muestran en la vista porque luego de la consulta a la API los datos a mostrar son diferentes -->
@endsection
