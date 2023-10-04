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
				<div class="col-sm-12 col-md-6 col-lg-6 mt-2">
					<div class="card">
						<h5 class="card-header text-center">Direccion de Inicio</h5>
						<div class="card-body">
							@if (Session::has('inicio'))
								<div><p class="card-text">{{ session('inicio')->direccion }}</p></div>	
								<form action="" method="POST">
									@csrf
									<button class="btn btn-primary mt-2 col-12">Cambiar</button>
								</form>
							@endif
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 mt-2">
					<div class="card">
						<h5 class="card-header text-center">Direccion Final</h5>
						<div class="card-body">
							@if (Session::has('final'))
								<div><p class="card-text">{{ session('final')->direccion }}</p></div>
								<form action="" method="POST">
									@csrf
									<button class="btn btn-primary mt-2 col-12">Cambiar</button>
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>	
		</div>


<br>


    <button class="btn btn-primary col-sm-12 col-md-3 col-lg-3 col-xl-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Cargar Excel</button>

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
			<table class="table table-striped table-dark">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Dirección</th>
					<th>N° de Paquete</th>
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
						@if (!empty($direccion->idDireccion))
							<td>
								<form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></button>
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
