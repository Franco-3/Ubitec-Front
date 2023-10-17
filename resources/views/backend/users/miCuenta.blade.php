@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')

<form action="{{route('users.update', $user->id)}}" method="POST">
    @csrf
    <label for="nombre" >Nombre:</label>
    <input name="nombre" type="input" value="{{$user->name}}" class="form-control">

    <label for="apelldio" >Apellido:</label>
    <input name="apellido" type="input" value="{{$user->lastName}}" class="form-control">

    <label for="telefono" >telefono:</label>
    <input name="telefono" type="input" value="{{$user->telefono}}" class="form-control">

    <label for="email" >Email:</label>
    <input name="email" type="input" value="{{$user->email}}" class="form-control">

    <label for="nombre" >Empresa:</label>
    <input name="empresa" type="input" value="{{$user->empresa}}" disabled class="form-control">
    <br>
    <input class="btn btn-primary" type="submit" value="Guardar">
</form>

@endsection