@extends('backend.layouts.main')

@section('title', 'Nueva Noticia')

@section('content')
    <h1>Nueva Noticia</h1>
    <div>
        @if (Session::has('status'))
            <div class="alert alert-success">{{ Session('status') }}</div>
        @endif
    </div>
    <div class="links">
        {{ Form::open(['route' => 'noticias.store', 'files' => true]) }}
        @csrf
        <div class="form-group @if ($errors->has('titulo')) has-error has-feedback @endif">
            {{ Form::label('titulo', 'Título', ['class' => 'control-label']) }}
            {{ Form::text('titulo', old('titulo'), ['class' => 'form-control', 'placeholder' => 'Ingrese el Título']) }}
            @error('titulo')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('cuerpo', 'Cuerpo', ['class' => 'control-label']) }}
            {{ Form::textarea('cuerpo', old('cuerpo'), ['class' => 'form-control', 'placeholder' => 'Ingrese el Cuerpo']) }}
            @error('cuerpo')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group @if ($errors->has('imagen')) has-error has-feedback @endif">
            {{ Form::label('imagen', 'Imagen', ['class' => 'control-label']) }}
            {{ Form::file('imagen') }}
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('categoria', 'Categoria', ['class' => 'control-label']) }}
            {{ Form::select('categoria', $categorias, null, ['class' => 'form-control']) }}
            @error('categoria')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('autor', 'Autor', ['class' => 'control-label']) }}
            {{ Form::text('autor', Auth::user()->name, ['class' => 'form-control']) }}
            @error('autor')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
    </br><button type="submit" style="width: 100%;" class="btn btn-primary">Guardar</button></div>
    {!! Form::close() !!}
@endsection