@extends('backend.layouts.main')
@section('title', 'Ubitec - Rutas')
@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        <p>Lo sentimos, se produjo un error: {{session('error')}}</p>
    </div>
@endif

<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <form action="{{route('direcciones.store')}}" method="post" >
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
								<button class="btn btn-primary mt-2 col-12">Cambiar</button>
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
								<button class="btn btn-primary mt-2 col-12">Cambiar</button>
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
						<div class="btn-group col-12" role="group" aria-label="Basic Example">
							<button class="btn btn-primary bg-gradient" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Abrir Mapa <i class="bi bi-globe-americas"></i></button>
							<a class="btn btn-primary" href="{{ route('rutas.create') }}" role="button">Nueva ruta</a>
							<a class="btn btn-primary" href="{{ route('google.ordenar') }}" role="button">Ordenar Direcciones</a>
							<!--<a href="{{ route('tsp.ordenar') }}" class="btn btn-primary">Ordenar Direcciones</a>-->
						</div>
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
                        <div style="height: 522px; width:100%;" id="map" class="specific border border-3 border-info rounded"></div>
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

@if ($kmTotal)
	<div class="conteiner">
		<p>Km Total de la ruta: {{$kmTotal}}</p>
	</div>
@endif

<div class="container mt-2">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<table id="index" class="table table-striped table-dark dt-responsive nowrap border border-dark">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Dirección</th>
					<th>N° de Paquete</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php $indice = 0 ?>
				@foreach ($direcciones as  $direccion)
					<?php $indice++ ?>
					<tr>
						<th class="text-center">{{$indice}}</th>
						<td>{{$direccion->direccion}}</td>
						<td>sin definir</td>
						<td>
							<label><input type='checkbox'><div class='check'></div></label>
						</td>
						@if (!empty($direccion->idDireccion))
							<td>
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

 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#index').DataTable({
            "language":{
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                "lengthMenu": "Mostrar de a _MENU_ registros",
            }
        });
    });
</script>

 @endsection