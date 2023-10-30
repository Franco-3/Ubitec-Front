<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI&libraries=places"></script>
    <script src="https://kit.fontawesome.com/3f6f78b811.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/logogps.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/app.css"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Tabla --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- CSS para Navbar de home --}}

    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">

</head>
<body class="d-flex flex-column min-vh-100" data-bs-theme="light">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg cid-tRPaqL6swe shadow-sm p-3 mb-5">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="./"><img src="img/logogps.png" style="width: 32px;" height="32" class="d-inline-block">UBITEC</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    @section('menu')
                    @guest
                    @else
                    <li class="nav-item hoverable"><a href="{{ url('/rutas') }}" class="nav-link link display-4">Rutas</a></li>
                    <li class="nav-item pe-2"><a href="{{ url('/historial') }}" class="nav-link link display-4" aria-expanded="false">Historial</a></li>
                    @if(Auth::user()->tipo === '0')
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('users.index') }}" aria-expanded="false">Usuarios</a></li>
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('vehiculos.index') }}" aria-expanded="false">Vehiculos</a></li>
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('direcciones.index') }}" aria-expanded="false">Direcciones</a></li>
                    @endif
                    @endguest

                    @show
                         <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link link display-4" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link link display-4" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                    @else
                    <li class="nav-item dropdown usuario">
                        <a class="nav-link link display-4 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} 
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{route('miCuenta')}}">Mi cuenta</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                </form>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button id="btnSwitch" class="btn btn-secondary" type="button"></button>
                    </li>
                    @endguest
                    @show
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
     <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            });

        //modo oscuro bootstrap
document.getElementById('btnSwitch').addEventListener('click',()=>{
  if (document.documentElement.getAttribute('data-bs-theme') == 'dark') {
      document.getElementsByTagName('body')[0].setAttribute('data-bs-theme','light');
      document.documentElement.setAttribute('data-bs-theme','light');
  }
  else {
      document.documentElement.setAttribute('data-bs-theme','dark')
      document.getElementsByTagName('body')[0].setAttribute('data-bs-theme','dark');
  }
});
    </script>
</body>
</html>
