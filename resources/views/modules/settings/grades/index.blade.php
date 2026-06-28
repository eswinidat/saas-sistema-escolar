@extends('layouts.admin')

@section('content')

<x-page-header title="Grados">
    <x-slot:actions>
        <a href="{{ route('settings.grades.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo grado</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Grado</th><th>Nivel</th><th>Orden</th><th>Estado</th><th width="160">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr>
                        <td>{{ $grade->name }}</td>
                        <td>{{ $grade->level->name ?? '—' }}</td>
                        <td>{{ $grade->order }}</td>
                        <td><span class="badge bg-{{ $grade->is_active ? 'success' : 'secondary' }}">{{ $grade->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td>
                            <a href="{{ route('settings.grades.edit', $grade) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('settings.grades.destroy', $grade) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Sin grados registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $grades->links() }}</div>
</x-card>

@endsection
