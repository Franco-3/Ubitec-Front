<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI&libraries=places"></script>
    <script src="https://kit.fontawesome.com/3f6f78b811.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/logogps.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="css/app.css"/> -->
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
                    @if(Auth::user()->tipo === '0')
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('users.index') }}" aria-expanded="false">Usuarios</a></li>
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('vehiculos.index') }}" aria-expanded="false">Vehiculos</a></li>
                    <li class="nav-item pe-2"><a class="nav-link link display-4" href="{{ route('direcciones.index') }}" aria-expanded="false">Direcciones</a></li>
                    @else
                    <li class="nav-item hoverable"><a href="{{ url('/rutas') }}" class="nav-link link display-4">Rutas</a></li>
                    <li class="nav-item pe-2"><a href="{{ url('/historial') }}" class="nav-link link display-4" aria-expanded="false">Historial</a></li>
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
                        <button id="btnSwitch" class="btn" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16">
                                <path id="svgPath" d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                            </svg>
                        </button>
                    </li>
                    @endguest
                    @show
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        //modo oscuro bootstrap
        var sol = 'M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z';
        var luna = 'M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z';
        var btnModoIcon = document.getElementById('svgPath');
        document.getElementById('btnSwitch').addEventListener('click',()=>{
        if (document.documentElement.getAttribute('data-bs-theme') == 'dark') {
            document.getElementsByTagName('body')[0].setAttribute('data-bs-theme','light');
            document.documentElement.setAttribute('data-bs-theme','light');
            btnModoIcon.setAttribute('d', luna);
        }
        else {
            document.documentElement.setAttribute('data-bs-theme','dark')
            document.getElementsByTagName('body')[0].setAttribute('data-bs-theme','dark');
            btnModoIcon.setAttribute('d', sol);
        }
        });
    </script>
</body>
</html>
