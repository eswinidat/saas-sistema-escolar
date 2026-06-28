@extends('layouts.admin')

@section('content')

<x-page-header title="Cursos / Áreas">
    <x-slot:actions>
        <a href="{{ route('academic.courses.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo curso</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Código</th><th>Curso</th><th>Grado</th><th>Horas/sem</th><th>Estado</th><th width="140">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->code ?? '—' }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->grade->name ?? 'Todos' }}</td>
                        <td>{{ $course->hours_per_week ?? '—' }}</td>
                        <td><span class="badge bg-{{ $course->is_active ? 'success' : 'secondary' }}">{{ $course->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td>
                            <a href="{{ route('academic.courses.edit', $course) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('academic.courses.destroy', $course) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Sin cursos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $courses->links() }}</div>
</x-card>

@endsection
