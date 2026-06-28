@extends('layouts.admin')

@section('content')

<x-page-header :title="$student->fullName()" subtitle="Ficha del alumno">
    <x-slot:actions>
        <a href="{{ route('enrollment.enrollments.create', ['student_id' => $student->id]) }}" class="btn btn-success">Matricular</a>
        <a href="{{ route('enrollment.students.edit', $student) }}" class="btn btn-warning">Editar</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<div class="row">
    <div class="col-md-6">
        <x-card title="Datos personales">
            <dl class="row mb-0">
                <dt class="col-sm-4">Documento</dt><dd class="col-sm-8">{{ $student->document_type }} {{ $student->document_number }}</dd>
                <dt class="col-sm-4">Nacimiento</dt><dd class="col-sm-8">{{ $student->birth_date?->format('d/m/Y') ?? '—' }}</dd>
                <dt class="col-sm-4">Estado</dt><dd class="col-sm-8">{{ \App\Modules\Enrollment\Models\Student::STATUSES[$student->status] ?? $student->status }}</dd>
                <dt class="col-sm-4">Teléfono</dt><dd class="col-sm-8">{{ $student->phone ?? '—' }}</dd>
                <dt class="col-sm-4">Dirección</dt><dd class="col-sm-8">{{ $student->address ?? '—' }}</dd>
            </dl>
        </x-card>
    </div>
    <div class="col-md-6">
        <x-card title="Apoderados">
            @forelse($student->guardians as $guardian)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ $guardian->fullName() }}</strong>
                    <div class="small text-muted">{{ $guardian->pivot->relationship }} · {{ $guardian->phone }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">Sin apoderados vinculados.</p>
            @endforelse
            <a href="{{ route('enrollment.guardians.create') }}" class="btn btn-sm btn-outline-primary mt-2">Registrar apoderado</a>
        </x-card>
    </div>
</div>

<x-card title="Historial de matrículas" class="mt-3">
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead><tr><th>Año</th><th>Sección</th><th>Tipo</th><th>Estado</th><th>Fecha</th></tr></thead>
            <tbody>
                @forelse($student->enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->academicYear->year ?? '—' }}</td>
                        <td>{{ $enrollment->section->grade->name ?? '' }} {{ $enrollment->section->name ?? '' }}</td>
                        <td>{{ \App\Modules\Enrollment\Models\Enrollment::TYPES[$enrollment->type] ?? $enrollment->type }}</td>
                        <td>{{ \App\Modules\Enrollment\Models\Enrollment::STATUSES[$enrollment->status] ?? $enrollment->status }}</td>
                        <td>{{ $enrollment->enrollment_date->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">Sin matrículas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

@endsection
