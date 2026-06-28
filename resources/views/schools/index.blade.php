@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏫 Colegios</h2>

        <a href="{{ route('schools.create') }}" class="btn btn-primary">
            Nuevo Colegio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUC</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th width="220">Acciones</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($schools as $school)

                    <tr>

                        <td>{{ $school->id }}</td>

                        <td>{{ $school->name }}</td>

                        <td>{{ $school->ruc }}</td>

                        <td>{{ $school->phone }}</td>

                        <td>
                            @if($school->status)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('schools.show',$school) }}" class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="{{ route('schools.edit',$school) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('schools.destroy',$school) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este colegio?')">
                                    Eliminar
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No existen colegios registrados.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $schools->links() }}

        </div>
    </div>

</div>
@endsection