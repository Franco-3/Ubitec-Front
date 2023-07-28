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

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />

    <style>
        .logo{
            background-image: url(img/logoubitec.gif);
            background-size: 100% 100%;
            width: 50px;
            height: 50px;
        }

    </style>
</head>
<body class="bg-secondary-subtle d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <button type="button" data-target="#navbarsExample02" aria-controls="navbarsExample02" data-toggle="collapse" class="navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" ></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample02">
            <ul class="navbar-nav mr-auto">
                @section('menu')
                <li class="nav-item">
                    <div class="logo"></div>
                </li>
                <li class="nav-item active">
                    <a href="/" class="logogps nav-link"><h2>UBITEC<span class="sr-only"></h2></span></a>
                </li>
                <li class="nav-item"><a class="nav-link  " href="{{ route('users.index') }}">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link  " href="{{ route('vehiculos.index') }}">Vehiculos</a></li>
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
                <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                    Cerrar Sesión
                                                    </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                               @csrf
                            </form>
                        </ul>
                </li>
            @endguest
           @show
           </ul>

        </div>

    </nav>


    @yield('content')
    @include('backend.layouts.footer')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>
</html>
