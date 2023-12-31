@extends('backend.layouts.main')
@section('title', 'Ubitec - Rutas')
@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        <p>Lo sentimos, se produjo un error: {{session('error')}}</p>
    </div>
@endif

<div class="container mt-2">
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('direcciones.store')}}" method="post" id="formDirecciones">
                    @csrf
						@if (is_null(session('inicio')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;" id="contenedorDirecccion">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de comienzo">
									<input id="tipo" type="hidden" value="inicio" name="tipo">
								</div>
							</div>
						@elseif(is_null(session('final')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;" id="contenedorDirecccion">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de final">
									<input id="tipo" type="hidden" value="final" name="tipo">
								</div>

							</div>
						@else
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;" id="contenedorDirecccion">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese la direccion a agregar">
									<input id="tipo" type="hidden" value="normal" name="tipo">
								</div>

							</div>
						@endif

				</form>
        </div>
    </div>

	<!-- mostrar direcciones de inicio y final  ToDo: hay que agregar los botones para modificarlas -->
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-2 px-1">
				<div class="card text-bg-dark bg-gradient">
					<h5 class="card-header text-center">Direccion de Inicio</h5>
					<div class="card-body">
						@if (Session::has('inicio'))
							<div><p class="card-text">{{ session('inicio')->direccion }}</p></div>
							<form action="{{ route('direcciones.destroy', session('inicio')->idDireccion) }}" method="POST">
								@csrf
								@method('DELETE')
								<button class="btn btn-success mt-2 col-12">Cambiar</button>
							</form>
						@endif
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-2 px-1">
				<div class="card text-bg-dark bg-gradient">
					<h5 class="card-header text-center">Direccion Final</h5>
					<div class="card-body">
						@if (Session::has('final'))
							<div><p class="card-text">{{ session('final')->direccion }}</p></div>
							<form action="{{ route('direcciones.destroy', session('final')->idDireccion) }}" method="POST">
								@csrf
								@method('DELETE')
								<button class="btn btn-success mt-2 col-12">Cambiar</button>
							</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
            <div class="container mt-2">
                <div class="row">
					<div class="btn-toolbar px-0" role="toolbar" aria-label="Toolbar with button groups">
						<div class="btn-group col-12 shadow" role="group" aria-label="Basic Example">
							<button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" id="abrirMapaButton">Abrir Mapa <i class="bi bi-globe-americas"></i></button>
							<a class="btn btn-success" href="{{ route('rutas.create') }}" role="button">Nueva ruta</a>
							<a class="btn btn-success" href="{{ route('tsp.ordenar') }}" role="button">Ordenar Direcciones</a>
							<!--<a href="{{ route('tsp.ordenar') }}" class="btn btn-primary">Ordenar Direcciones</a>-->
						</div>
					</div>
                </div>
            </div>
            <div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                <div class="offcanvas-header bg-light bg-gradient">
                    <h5 class="offcanvas-title fw-bold text-decoration-underline" id="offcanvasBottomLabel">Mapa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body bg-dark-subtle">
                    <div class="container">
						<div id="map"></div>
                    </div>
                </div>
            </div>
            <!-- Mapa desplegable -->
			<div class="map-table" name="map"></div>

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

<div class="container">
	<div class="row d-flex justify-content-center">
		@if ($kmTotal)
			<div class="bg-primary col-sm-12 col-md-5 rounded mt-2 py-2 text-center text-light border border-secondary">
				<span>KM Total de la Ruta: {{$kmTotal}}</span>
			</div>
		@endif
		<div class="col-sm-12 col-md-5 mt-2">
			@if ($kmTotal)
				<button id="generar_excel" class="btn btn-primary" onclick="generarExcel()">Generar excel</button>
			@endif

			@if (Session::has('inicio') && Session::has('final'))
				<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#excelbottom" aria-controls="excelbottom">Cargar Excel</button>
			@endif
		</div>
	</div>
</div>

<div class="container mt-2">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<table id="index" class="table table-striped dt-responsive" style="width: 100%">
            <thead>
				<tr>
					<th class="text-center">#</th>
					<th>Dirección</th>
					<th>Agregar</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php $indice = 0 ?>
				@foreach ($direcciones as  $direccion)
					<?php $indice++ ?>
					<tr>
						<td class="text-center">{{$indice}}</td>
						<td>{{$direccion->direccion}}</td>
						<td class="text-center">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-success p-2" id="img_desc" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="cambiarId({{ $direccion->idDireccion }}, '{{ $direccion->descripcion }}', `{{ $direccion->imagen}}`)">
								Editar
							</button>
						</td>
						<td>
							<label>
								<form>
									<input name='estado' type='checkbox' onchange="cambiarEstado({{ $direccion->idDireccion }}, this.checked)" {{ $direccion->estado ? 'checked' : '' }}>
									<div class='check mx-auto'></div>
								</form>
							</label>
						</td>
						@if (!empty($direccion->idDireccion))
							<td class="text-center">
								<form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
								</form>
							</td>
						@endif
					</tr>
				@endforeach
			</tbody>
			</table>
		</div>
	</div>
</div>


@if ($imagenRuta)
    <script>
		console.log('entro');
		document.addEventListener('DOMContentLoaded', function() {
			// Agrega un oyente de eventos al botón "Abrir Mapa"
			const abrirMapaButton = document.getElementById('abrirMapaButton');

			abrirMapaButton.addEventListener('click', function() {
				// Cuando se hace clic en el botón "Abrir Mapa", se abrirá el modal
					console.log('hola');
					// Ahora puedes tomar la captura del mapa
					capturarImagen();
					console.log('El modal se ha abierto completamente. Capturando la imagen del mapa.');
			});
		});
    </script>
@endif


<div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="excelbottom" aria-labelledby="excelbottomLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="excelbottomLabel">Cargar Excel</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="container">
				<h3>Cargar Archivo Excel</h3>
				<form action="{{ route('cargar.excel') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="file" class="form-control"  name="archivo_excel" accept=".xlsx, .xls">
					<br>
					<button type="submit" class="btn btn-primary" >Cargar Excel</button>
				</form>
		</div>
	</div>
</div>


<!-- Modal para agregar descripcion e imagen-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<h1 class="modal-title fs-5" id="exampleModalLabel">Agregar descripción</h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<form action="{{ route('direccion.imagen') }}" method="post" enctype="multipart/form-data">
			@csrf <!-- Asegúrate de incluir el token CSRF para proteger tu formulario -->
			<input class="form-control" type="file" name="imagen" id="imagen" accept="image/png, image/jpeg, image/jpg, image/bmp, image/tif">
			<textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="7"></textarea>
			<input type="hidden" name="id" id="idDireccion">
			<br>
			<button class="btn btn-primary" type="submit" id="editForm" class="btn btn-primary">Guardar cambios</button>
		</form>
			<br>
			<button class="btn btn-success p-2" id="botonDescargar">Ver Imagen Actual</button>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	</div>
	</div>
</div>
</div>

<script src="{{ asset('js/imagen_descripcion.js') }}"></script> {{-- javascript para capturar la imagen y la descripcion --}}


 @endsection
