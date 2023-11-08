@extends('backend.layouts.main')
@section('title', 'Ubitec - Usuarios')
@section('content')
<div class="container mt-5">
    @if($users->isNotEmpty())
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="index" class="table table-striped dt-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th>Empresa</th>
                            <th>
                                <a class="btn btn-success" href="{{ route('users.create') }}">
                                    <i class="bi bi-person-fill-add"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td> {{ $user->name }} {{ $user->lastName }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->empresa }}</td>
                                <td>
                                    {{ Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id]]) }}
                                    @csrf
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar" onclick="if (!confirm('EstÃ¡ seguro de borrar el usuario?')) return false;"><i class="bi bi-trash3"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-primary text-center" role="alert">
                                        No hay usuarios.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-primary text-center" role="alert">
            No hay usuarios.
        </div>
    @endif
</div>

@endsection
