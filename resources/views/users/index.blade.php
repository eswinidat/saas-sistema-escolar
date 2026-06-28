@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>👥 Usuarios</h2>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Nuevo Usuario
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Listado de Usuarios</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th width="220">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>

                            @if($user->roles->count())

                                <span class="badge bg-success">
                                    {{ $user->roles->first()->name }}
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Sin Rol
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('users.show',$user) }}"
                               class="btn btn-info btn-sm">

                                Ver

                            </a>

                            <a href="{{ route('users.edit',$user) }}"
                               class="btn btn-warning btn-sm">

                                Editar

                            </a>

                            <form action="{{ route('users.destroy',$user) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar usuario?')">

                                    Eliminar

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No existen usuarios.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $users->links() }}

        </div>

    </div>

</div>

@endsection