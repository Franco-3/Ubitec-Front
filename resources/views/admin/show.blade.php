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
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de comienzo">
									<input id="tipo" type="hidden" value="inicio" name="tipo">
								</div>

							</div>
						@elseif(is_null(session('final')))
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese dirección de final">
									<input id="tipo" type="hidden" value="final" name="tipo">
								</div>

							</div>
						@else
							<div style="display: flex; justify-content: center;">
								<div style="flex: 1; margin-right: 10px;">
									<input class="form-control" type="text" id="search_input" name="direccion" placeholder="Ingrese la direccion a agregar">
									<input id="tipo" type="hidden" value="normal" name="tipo">
								</div>

							</div>
						@endif

				</form>
        </div>
    </div>

	<a class="btn btn-primary col-sm-12 col-md-3 col-lg-3 col-xl-3" href="{{ route('nueva_ruta', $id) }}" role="button">Nueva ruta</a>

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


<br>


<button class="button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#fffffff" stroke-width="2"></path>
        <path d="M17 15V18M17 21V18M17 18H14M17 18H20" stroke="#fffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    Cargar Excel
</button>

    <div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Cargar Excel</h5>
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

<br>

            <!-- Mapa desplegable -->
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

			<script>
				// Define una variable global de JavaScript con el token CSRF
				window.csrfToken = "{{ csrf_token() }}";
			</script>
</div>


<div class="container mt-2">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<table id="index" class="table table-striped dt-responsive" style="width: 100%">
                <thead>
				<tr>
					<th class="text-center">#</th>
					<th>Dirección</th>
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
						@if (!empty($direccion->idDireccion))
							<td>
								<form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></button>
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

<!-- <button class="btn btn-primary mx-auto mb-2 col-2"><a href="{{ route('tsp.ordenar') }}" class="link-light text-decoration-none">Ordenar Direcciones</a></button> faltan modificaciones de los datos que se muestran en la vista porque luego de la consulta a la API los datos a mostrar son diferentes -->
@endsection
