@extends('layouts.admin')

@section('content')

<x-page-header title="Matrículas">
    <x-slot:actions>
        <a href="{{ route('enrollment.enrollments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nueva matrícula</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Código</th><th>Alumno</th><th>Año</th><th>Sección</th><th>Tipo</th><th>Estado</th><th width="120">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->enrollment_number ?? '—' }}</td>
                        <td>{{ $enrollment->student->fullName() ?? '—' }}</td>
                        <td>{{ $enrollment->academicYear->year ?? '—' }}</td>
                        <td>{{ $enrollment->section->grade->name ?? '' }} {{ $enrollment->section->name ?? '' }}</td>
                        <td>{{ \App\Modules\Enrollment\Models\Enrollment::TYPES[$enrollment->type] ?? $enrollment->type }}</td>
                        <td>{{ \App\Modules\Enrollment\Models\Enrollment::STATUSES[$enrollment->status] ?? $enrollment->status }}</td>
                        <td><a href="{{ route('enrollment.enrollments.edit', $enrollment) }}" class="btn btn-sm btn-warning">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin matrículas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $enrollments->links() }}</div>
</x-card>

@endsection
