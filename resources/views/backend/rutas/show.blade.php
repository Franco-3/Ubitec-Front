@extends('backend.layouts.main')
@section('title', 'Noticias')
@section('menu')
@parent
<li class="nav-item"><a href="#" class="nav-link">Nuevo</a></li>
<li class="nav-item"><a href="#" class="nav-link">Editar</a></li>
<li class="nav-item"><a href="#" class="nav-link">Eliminar</a></li>
@endsection
@section('content')
<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-5">
            @if($noticia->imagen)
            @if(Str::startsWith($noticia->imagen, 'http'))
            <img src="{{ $noticia->imagen }}" alt="..." class="card-img-top">
            @endif
            @else
            <img src="../img/no_image.png" alt="no image">
            @endif
        </div>
        <div class="col-md-7">
            <div class="card-body">
                <h5 class="card-title">{{ $noticia->titulo}}</h5>
                <p class="card-text">{!! $noticia->cuerpo !!}</p>
                <p class="card-text"><small class="text-muted">{{-- $noticia->creadaPor->name --}}</small></p>
            </div>
        </div>
    </div>
</div>


@endsection