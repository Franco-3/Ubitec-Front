@extends('backend.layouts.main')
@section('title', 'Ubitec - Usuarios') 
@section('content')
    @forelse($users as $user)
        @if ($loop->first)
        <div class="container">
            <table id="index" class="table table-striped dt-responsive nowrap border border-dark" style="width: 100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <td>
                            <a class="btn btn-success" href="{{ route('users.create') }}">
                                <i class="bi bi-person-fill-add"></i>
                            </a>
                        </td>
                    </tr>
                </thead>
        @endif
        <tbody>
            <tr>
                <td>{{ $user->id }}</td>
                <td> {{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>
                    {{ Form::model($user, ['method' => 'delete', 'route' => ['users.destroy', $user->id]]) }}
                    @csrf
                    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"><i class="bi bi-eye" style="color: white"></i></a>
                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#index').DataTable({
            "language":{
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                "lengthMenu": "Mostrar de a _MENU_ registros",
            }
        });
    });
</script>

@endsection
