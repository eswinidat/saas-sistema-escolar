@extends('layouts.admin')

@section('content')

<x-page-header title="Asignaciones Docente">
    <x-slot:actions>
        <a href="{{ route('academic.assignments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nueva asignación</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Docente</th><th>Curso</th><th>Sección</th><th>Año</th><th width="100">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->teacher->fullName() ?? '—' }}</td>
                        <td>{{ $assignment->course->name ?? '—' }}</td>
                        <td>{{ $assignment->section->grade->name ?? '' }} {{ $assignment->section->name ?? '' }}</td>
                        <td>{{ $assignment->academicYear->year ?? '—' }}</td>
                        <td>
                            <form action="{{ route('academic.assignments.destroy', $assignment) }}" method="POST">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar asignación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Sin asignaciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $assignments->links() }}</div>
</x-card>

@endsection
