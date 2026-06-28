@extends('layouts.admin')

@section('content')

<x-page-header
    title="Roles"
    subtitle="Administración de roles del sistema">

    <x-slot:actions>

        <x-button
            href="{{ route('roles.create') }}"
            color="primary"
            icon="bi bi-plus-circle">

            Nuevo Rol

        </x-button>

    </x-slot:actions>

</x-page-header>

<x-alert />

<x-card
    title="Listado de Roles"
    subtitle="Roles registrados en el sistema">

    <table class="table table-bordered table-hover align-middle">

        <thead class="table-light">

            <tr>

                <th width="80">ID</th>

                <th>Nombre</th>

                <th width="260">Acciones</th>

            </tr>

        </thead>

        <tbody>

            @forelse($roles as $role)

                <tr>

                    <td>{{ $role->id }}</td>

                    <td>{{ $role->name }}</td>

                    <td>

                        <x-button
                            href="{{ route('roles.show', $role) }}"
                            color="info"
                            class="btn-sm"
                            icon="bi bi-eye">

                            Ver

                        </x-button>

                        <x-button
                            href="{{ route('roles.edit', $role) }}"
                            color="warning"
                            class="btn-sm"
                            icon="bi bi-pencil-square">

                            Editar

                        </x-button>

                        <form
                            action="{{ route('roles.destroy', $role) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <x-button
                                color="danger"
                                type="submit"
                                class="btn-sm"
                                icon="bi bi-trash"
                                onclick="return confirm('¿Eliminar este rol?')">

                                Eliminar

                            </x-button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3" class="text-center">

                        No existen roles registrados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <x-slot:footer>

        {{ $roles->links() }}

    </x-slot:footer>

</x-card>

@endsection