@extends('layouts.admin')

@section('content')

<x-page-header :title="$teacher->fullName()" subtitle="Ficha del docente">
    <x-slot:actions>
        <a href="{{ route('academic.teachers.edit', $teacher) }}" class="btn btn-warning">Editar</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<div class="row">
    <div class="col-md-5">
        <x-card title="Información personal">
            <dl class="row mb-0">
                <dt class="col-sm-5">Documento</dt><dd class="col-sm-7">{{ $teacher->document_type }} {{ $teacher->document_number }}</dd>
                <dt class="col-sm-5">Especialidad</dt><dd class="col-sm-7">{{ $teacher->specialty ?? '—' }}</dd>
                <dt class="col-sm-5">Teléfono</dt><dd class="col-sm-7">{{ $teacher->phone ?? '—' }}</dd>
                <dt class="col-sm-5">Correo</dt><dd class="col-sm-7">{{ $teacher->email ?? '—' }}</dd>
                <dt class="col-sm-5">Estado</dt><dd class="col-sm-7">{{ \App\Modules\Academic\Models\Teacher::STATUSES[$teacher->status] ?? $teacher->status }}</dd>
            </dl>
        </x-card>
    </div>
    <div class="col-md-7">
        <x-card title="Asignaciones actuales">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Curso</th><th>Sección</th><th>Año</th></tr></thead>
                    <tbody>
                        @forelse($teacher->assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->course->name ?? '—' }}</td>
                                <td>{{ $assignment->section->grade->name ?? '' }} {{ $assignment->section->name ?? '' }}</td>
                                <td>{{ $assignment->academicYear->year ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-muted">Sin asignaciones.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('academic.assignments.create') }}" class="btn btn-sm btn-outline-primary mt-2">Nueva asignación</a>
        </x-card>
    </div>
</div>

@endsection
