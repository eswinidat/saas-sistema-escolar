@extends('layouts.admin')

@section('content')

<x-page-header title="Docentes">
    <x-slot:actions>
        <a href="{{ route('academic.teachers.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo docente</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Documento</th><th>Nombre</th><th>Especialidad</th><th>Estado</th><th width="180">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->document_type }} {{ $teacher->document_number }}</td>
                        <td>{{ $teacher->fullName() }}</td>
                        <td>{{ $teacher->specialty ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ \App\Modules\Academic\Models\Teacher::STATUSES[$teacher->status] ?? $teacher->status }}</span></td>
                        <td>
                            <a href="{{ route('academic.teachers.show', $teacher) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('academic.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Sin docentes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $teachers->links() }}</div>
</x-card>

@endsection
