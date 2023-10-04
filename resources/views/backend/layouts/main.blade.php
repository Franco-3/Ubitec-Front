<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI&libraries=places"></script>
    <script src="https://kit.fontawesome.com/3f6f78b811.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/logogps.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/app.css"/>
    {{-- Tabla --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
            <button type="button" data-target="#navbarsExample02" aria-controls="navbarsExample02" data-toggle="collapse" class="navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" ></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="img/logogps.png" alt="Logo ubitec" width="34" height="34" class="d-inline-block align-text-top">
                UBITEC
            </a>
            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav">
                    @section('menu')
                    @guest
                    @else
                    <li class="nav-item"><a href="{{ url('/rutas') }}" class="nav-link">Rutas</a></li>
                    <li class="nav-item"><a href="{{ url('/historial') }}" class="nav-link" aria-expanded="false">Historial</a></li>
                    @if(Auth::user()->tipo === '0')
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}" aria-expanded="false">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('vehiculos.index') }}" aria-expanded="false">Vehiculos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('direcciones.index') }}" aria-expanded="false">Direcciones</a></li>
                    @endif
                    @endguest

                    @show
                </ul>

                <ul class="navbar-nav ms-auto me-5">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                    <li class="nav-item text-light d-flex">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item text-light">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }} </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Cerrar Sesión</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                </li>
                            </ul>
                    </li>
                @endguest
            @show
            </ul>

            </div>
        </div>
    </nav>

    @yield('content')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>

</html>
