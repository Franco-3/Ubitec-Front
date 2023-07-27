@extends('backend.layouts.main')
@section('title', 'Usuarios')
@section('content')
    <h3 class="text-dark">Lista de usuarios</h3>
    @forelse($users as $user)
        @if ($loop->first)
            <table class="table table-dark">
                <tr>
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Email</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('users.create') }}">
                            <img src="{{ asset('svg/new.svg') }}" width="20" height="20" alt="Crear" title="Crear">
                        </a>
                    </td>
                </tr>
        @endif
        <tr>
            <td>{{ $user->id }}</td>
            <td> {{ $user->name }}</a></td>
            <td>{{ $user->email }}</td>
            <td>
                {{ Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id]]) }}
                @csrf
                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-info"><img
                        src="{{ asset('svg/show.svg') }}" width="20" height="20" alt="Mostrar" title="Mostrar"></a>
                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary"><img
                        src="{{ asset('svg/edit.svg') }}" width="20" height="20" alt="Editar" title="Editar"></a>
                <button type="submit" class="btn btn-danger"
                    onclick="if (!confirm('Está seguro de borrar el usuario?')) return false;"><img
                        src="{{ asset('svg/delete.svg') }}" width="20" height="20" alt="Borrar"
                        title="Borrar"></button>
                {!! Form::close() !!}
            </td>
        </tr>
        @if ($loop->last)
            </table>
        @endif
    @empty
        <p class="text-capitalize"> No hay usuarios.</p>
    @endforelse
    </div>
    <hr>
    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        <!--
          Agregar en App\Providers\AppServiceProvider:
          use Illuminate\Pagination\Paginator;
              public function boot() { Paginator::useBootstrap(); } -->
        {!! $users->links() !!}
    </div>
@endsection
