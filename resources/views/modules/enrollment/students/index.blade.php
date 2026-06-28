@extends('layouts.admin')

@section('content')

<x-page-header title="Alumnos">
    <x-slot:actions>
        <a href="{{ route('enrollment.students.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo alumno</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Documento</th><th>Apellidos y nombres</th><th>Estado</th><th width="200">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->document_type }} {{ $student->document_number }}</td>
                        <td>{{ $student->fullName() }}</td>
                        <td><span class="badge bg-secondary">{{ \App\Modules\Enrollment\Models\Student::STATUSES[$student->status] ?? $student->status }}</span></td>
                        <td>
                            <a href="{{ route('enrollment.students.show', $student) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('enrollment.students.edit', $student) }}" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Sin alumnos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $students->links() }}</div>
</x-card>

@endsection
