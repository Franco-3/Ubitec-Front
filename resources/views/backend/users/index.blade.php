@extends('backend.layouts.main')
@section('title', 'Ubitec - Usuarios')
@section('content')
    @forelse($users as $user)
        @if ($loop->first)
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="index" class="table table-striped dt-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Id</th>
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
                    @endif
                    <tbody>
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td> {{ $user->name }} {{ $user->lastName }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->empresa }}</td>
                            <td>
                                {{ Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id]]) }}
                                @csrf
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar"
                                    onclick="if (!confirm('Está seguro de borrar el usuario?')) return false;"><i class="bi bi-trash3"></i></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </tbody>
                    @if ($loop->last)
                        </table>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-capitalize"> No hay usuarios.</p>
    @endforelse
    </div>
    {{-- <hr>
    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        <!--
          Agregar en App\Providers\AppServiceProvider:
          use Illuminate\Pagination\Paginator;
              public function boot() { Paginator::useBootstrap(); } -->
        {!! $users->links() !!}
    </div> --}}


@endsection
