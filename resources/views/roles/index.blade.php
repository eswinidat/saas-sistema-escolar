@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">

        <h2>Roles</h2>

        <a href="{{ route('roles.create') }}"
           class="btn btn-primary">

            Nuevo Rol

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Nombre</th>

                        <th width="220">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($roles as $role)

                    <tr>

                        <td>{{ $role->id }}</td>

                        <td>{{ $role->name }}</td>

                        <td>

                            <a href="{{ route('roles.show',$role) }}"
                               class="btn btn-info btn-sm">

                                Ver

                            </a>

                            <a href="{{ route('roles.edit',$role) }}"
                               class="btn btn-warning btn-sm">

                                Editar

                            </a>

                            <form
                                action="{{ route('roles.destroy',$role) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar rol?')">

                                    Eliminar

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3"
                            class="text-center">

                            No existen roles.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $roles->links() }}

        </div>

    </div>

</div>

@endsection