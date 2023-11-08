@extends('backend.layouts.main')
@section('title', 'Administrador')
@section('content')

<br>
    <div class="button-container">
        <button class="button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#fffffff" stroke-width="2"></path>
                <path d="M17 15V18M17 21V18M17 18H14M17 18H20" stroke="#fffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Cargar Excel
        </button>
    </div>


    <div class="offcanvas offcanvas-bottom offcanvas-size-xl" style="height: 80vh;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasBottomLabel">Cargar Archivo Excel</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container">
                <p>Esta opcion esta en desarrollo, dividira todas las direcciones del archivo entre todos los vehivulos que existan de la forma mas optima posible, generando una ruta para cada vehiculo</p>
                <form action="{{ route('dividir.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control" name="archivo_excel" accept=".xlsx, .xls">
                    <br>
                    <button type="submit" class="btn btn-primary my-1" >Cargar Excel</button>
                </form>
            </div>
        </div>
    </div>

<br>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-xxl-6 mt-4 mb-4"> <!-- Tabla para vehiculos sin asignar -->
                <table class="table table-striped dt-responsive vehiculos-table mt-4 mb-4" style="width: 100%">
                        <caption>Usuarios sin asignar</caption>
                        <thead>
                            <tr>
                                <th>Patente</th>
                                <th>Nombre</th>
                                <th class="text-center">Usuario Asignado</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->patente }}</td>
                                <td> {{ $vehiculo->nombre }}</a></td>
                                <td class="text-center">
                                    Sin asignar
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>

            <div class="col-sm-12 col-xl-12 col-xxl-6 mt-4 mb-4"> <!-- Tabla de direcciones sin completar -->
                <table class="table table-striped dt-responsive direcciones-table" style="width: 100%">
                    <caption>Direcciones sin completar</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Direccion</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($direcciones as $direccion)
                        <tr>
                            <td>{{ $direccion->idDireccion }}</td>
                            <td>{{ $direccion->direccion }}</td>
                            <td>{{ $direccion->tipo }}</td>
                            <td class="text-center">
                                <label>
                                    <form>
                                        <input name='estado' type='checkbox' disabled {{ $direccion->estado ? 'checked' : '' }}>
                                        <div class='check mx-auto'></div>
                                    </form>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>

    <div class="container mt-4 mb-4">
        <table class="table table-striped dt-responsive vehiculos-usuario-table" style="width: 100%">
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
                    <td scope="row">{{$indice}}</td>
                    <td>{{$vUsuario->nombre}}</td>
                    <td>{{$vUsuario->patente}}</td>
                    <td>{{$vUsuario->name}}</td>
                    @if (!empty($vUsuario->idVehiculo))
                        <td>
                            <form action="{{ route('dashboard.show', $vUsuario->id) }}" method="POST">
                                @csrf
                                @method('GET')
                                <button type="submit" class="button2">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path></svg> Asignar Direcciones
                                    </span>
                                </button>
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
