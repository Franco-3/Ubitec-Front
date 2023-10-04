@extends('backend.layouts.main')
@section('title', 'Administrador')
@section('content')

<br>


    <button class="btn btn-primary col-sm-12 col-md-3 col-lg-3 col-xl-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Cargar Excel</button>

    <div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Cargar Excel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container">
                <p>Esta opcion esta en desarrollo, dividira todas las direcciones del archivo entre todos los vehivulos que existan de la forma mas optima posible, generando una ruta para cada vehiculo</p>
                <h3>Cargar Archivo Excel</h3>
                <form action="{{ route('dividir.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control" name="archivo_excel" accept=".xlsx, .xls">
                    <br>
                    <button type="submit" class="btn btn-primary" >Cargar Excel</button>
                </form>
            </div>
        </div>
    </div>

<br>


    <div class="container">
        <table class="table table-striped table-dark">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">vehiculo</th>
            <th scope="col">N° de patente</th>
            <th scope="col">Usuario</th>
            <th scope="col">Cant direcciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $indice = 0 ?>
            @foreach ($vehiculosUsuario as  $vUsuario)
                <?php $indice++ ?>
                <tr>
                    <th scope="row">{{$indice}}</th>
                    <td>{{$vUsuario->nombre}}</td>
                    <td>{{$vUsuario->patente}}</td>
                    <td>{{$vUsuario->name}}</td>
                    @if (!empty($vUsuario->idVehiculo))
                        <td>
                            <form action="{{ route('dashboard.show', $vUsuario->id) }}" method="POST">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-danger btn-sm">asignar direcciones</button>
                            </form>
                        </td>
                    @endif
{{--                     @if (!empty($direccion->idDireccion))
                        <td>
                            <form action="{{ route('direcciones.destroy', $direccion->idDireccion) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    @endif --}}
                </tr>
            @endforeach


        </tbody>
        </table>
    </div>


    

@endsection




