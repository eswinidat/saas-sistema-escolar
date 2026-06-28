@extends('layouts.admin')

@section('content')

<x-page-header title="Niveles Educativos">
    <x-slot:actions>
        <a href="{{ route('settings.levels.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo nivel</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Orden</th><th>Nombre</th><th>Código</th><th>Estado</th><th width="160">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($levels as $level)
                    <tr>
                        <td>{{ $level->order }}</td>
                        <td>{{ $level->name }}</td>
                        <td>{{ $level->code ?? '—' }}</td>
                        <td><span class="badge bg-{{ $level->is_active ? 'success' : 'secondary' }}">{{ $level->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td>
                            <a href="{{ route('settings.levels.edit', $level) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('settings.levels.destroy', $level) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Sin niveles registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $levels->links() }}</div>
</x-card>

@endsection
