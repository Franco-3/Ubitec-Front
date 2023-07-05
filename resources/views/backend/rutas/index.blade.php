@extends('backend.layouts.main')
@section('title', 'Ubitec - Rutas')
@section('menu')
@parent
<li class="nav-item m-5"><a href="{{ url('/historial') }}" class="nav-link">Historial</a></li>
@endsection
@section('content')

<?php


$server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ubitec';

    try{
        $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    }catch(PDOexception $e){
        die('Connection failed: '.$e->getMessage());
    }



if(isset($_SESSION['direc'])){

  $array = $_SESSION['direc'];
}

if(isset($_SESSION['startEnd']) && !empty($_SESSION['startEnd']['ruta_inicio'])){
  $start = $_SESSION['startEnd']['ruta_inicio'];
}

if(isset($_SESSION['startEnd']) && !empty($_SESSION['startEnd']['ruta_final'])){
  $end = $_SESSION['startEnd']['ruta_final'];
}

if(!isset($_SESSION['data'])){
    $_SESSION['data'] = array();
}
?>

<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <form method="post" >
                    @csrf
						<?php
							//evalua si la ruta de inicio fue ingresada
							if(empty($_SESSION['startEnd']['ruta_inicio'])):
								$start = "";
								$array = "";
								$end = "";
						?>
                        <div style="display: flex; justify-content: center;">
                            <div style="flex: 1; margin-right: 10px;">
                                <input class="form-control" type="text" id="search_input" name="searchStart" placeholder="Ingrese dirección de comienzo">
                            </div>
                            <div style="flex: 1; margin-left: 10px;">
                                <label for="add_start" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i>
                                </label>
                                <input name="add_start" type="submit" id="add_start" style="display: none;">
                            </div>
                        </div>

						<?php endif; ?>
						<?php
							//evalua si esta vacia la ruta final para pedir que sea ingresada (corregir boton añadir)
							if(empty($_SESSION['startEnd']['ruta_final']) && !empty($_SESSION['startEnd']['ruta_inicio'])):
						?>
						<div>
							<input type="text" id="search_input" name="searchEnd"  placeholder="Ingrese direccion final">
							<input type="submit" class="btn btn-success" id="add_end" value="Añadir">
						</div>
						<?php
							//evalua si estan ambas rutas ingresadas para pedir las direcciones
							elseif(!empty($_SESSION['startEnd']['ruta_final']) && !empty($_SESSION['startEnd']['ruta_inicio'])):
						?>
							<input type="text" id="search_input" name="searchAddress"  placeholder="Por favor ingrese la direccion">
							<input type="hidden" name="valores" value="<?php echo implode(",", $_SESSION['data']); ?>">
							<input name="add" class="btn btn-success" type="submit" id="add" value="Añadir">
						<?php
							endif;
						?>
				</form>
        </div>
    </div>

                <?php
						//evalua si la ruta de inicio fue ingresada para mostrarla con su boton de cambiar
					if(!empty($_SESSION['startEnd']['ruta_inicio'])):
				?>
					<div class="container">
						<div class="cajatres">
							<form method="POST">
								<label for="start">Direccion de comienzo: <?php echo $_SESSION['startEnd']['ruta_inicio']; ?> </label>
								<input type="submit" name="change_start" value="Cambiar ruta inicio" />
							</form>
						</div>
						<!-- evalua si la ruta final fue ingresada para mostrarla con su boton de cambiar -->
						<?php if(!empty($_SESSION['startEnd']['ruta_final'])): ?>
							<div class="cajatres">
								<form method="POST">
									<label for="start">Direccion Final: <?php echo $_SESSION['startEnd']['ruta_final']; ?> </label>
									<input type="submit" name="change_end" value="Cambiar ruta Final" />
								</form>
							</div>
					</div>
					<?php endif; ?>
				<?php
						endif;
				?>
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
			<div class="map-table" name="map">

					<div class="info">
						<?php
							//evalua si hay direccion de inicio o alguna direccion cargada para mostrar la estructura y tabla
							if(!empty($_SESSION['direc']) && !empty($_SESSION['startEnd']['ruta_inicio'])):
						?>
						<table>
							<tr>
								<td>Direcciones</td>
							</tr>
								<!-- Imprime tabla con boton para eliminar -->
								<?php
									for($var=0; $var < count($_SESSION['direc']); $var++):
								?>
								<form method="POST">
									<tr><td>
										<?php echo $_SESSION['direc'][$var]; ?>
										<input type="hidden" name="deleteValue" value="<?php echo $_SESSION['direc'][$var]; ?>" />
										<div class="eliminar">
											<input type="submit" name="deleteOne" value="Eliminar"><!--boton para eliminar individual -->
											<label><input type='checkbox'><div class='check'></div></label>
										</div>
									</td></tr>
								</form>
								<?php
									endfor;
								?>



						</table>
						<!-- boton eliminar toodo -->
						<form method="POST">
							<input type="submit" id="delete" name="delete" value="Eliminar todo" />
							<input type="submit" id="new" name="new" value="Nueva Ruta" />
							<input type="submit" onclick="exportToCsv()" value="Descargar en Exel" />
						</form>

						<div id="directions-panel"><strong>Rutas ordenadas</strong></div>

						<?php endif; ?>
                        <!-- boton ordenar y mostrar -->
							<input class="invisible" type="submit" id="submit" value="Ordenar y mostrar" />
					</div>
			</div>

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
		<tr>
		<th scope="row">1</th>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<th scope="row">2</th>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<th scope="row">3</th>
		<td></td>
		<td></td>
		<td></td>
		</tr>
	</tbody>
	</table>
</div>



@endsection
