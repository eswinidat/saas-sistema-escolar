@extends('layouts.admin')

@section('content')

<x-page-header title="Registro de asistencia diaria" subtitle="Marque la asistencia de todos los alumnos de la sección" />

<x-alert />

<x-card title="Seleccionar sección y fecha">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Sección</label>
            <select name="section_id" class="form-select" required>
                <option value="">Seleccione sección</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected($sectionId == $section->id)>
                        {{ $section->grade->name ?? '' }} — {{ $section->name }} ({{ $section->academicYear->year ?? '' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Año académico</label>
            <select name="academic_year_id" class="form-select" required>
                @foreach($academicYears as $id => $yearLabel)
                    <option value="{{ $id }}" @selected($academicYearId == $id)>{{ $yearLabel }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control" value="{{ $date }}" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cargar lista</button>
        </div>
    </form>
</x-card>

@if($students->isNotEmpty())
    <x-card title="Lista de alumnos — {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" class="mt-3">
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="school_id" value="{{ $selectedSchoolId }}">
            <input type="hidden" name="section_id" value="{{ $sectionId }}">
            <input type="hidden" name="academic_year_id" value="{{ $academicYearId }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th width="160">Estado</th>
                            <th width="110">Entrada</th>
                            <th width="110">Salida</th>
                            <th width="100">Tardanza (min)</th>
                            <th>Justificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                            @php $existing = $existingRecords->get($student->id); @endphp
                            <input type="hidden" name="records[{{ $index }}][student_id]" value="{{ $student->id }}">
                            <tr>
                                <td>
                                    <strong>{{ $student->fullName() }}</strong>
                                    <div class="small text-muted">{{ $student->document_number }}</div>
                                </td>
                                <td>
                                    <select name="records[{{ $index }}][status]" class="form-select form-select-sm">
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}" @selected(old("records.{$index}.status", $existing?->status ?? 'present') == $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="time" name="records[{{ $index }}][check_in_time]" class="form-control form-control-sm"
                                           value="{{ old("records.{$index}.check_in_time", $existing?->check_in_time ? substr($existing->check_in_time, 0, 5) : '') }}">
                                </td>
                                <td>
                                    <input type="time" name="records[{{ $index }}][check_out_time]" class="form-control form-control-sm"
                                           value="{{ old("records.{$index}.check_out_time", $existing?->check_out_time ? substr($existing->check_out_time, 0, 5) : '') }}">
                                </td>
                                <td>
                                    <input type="number" name="records[{{ $index }}][tardiness_minutes]" class="form-control form-control-sm" min="0"
                                           value="{{ old("records.{$index}.tardiness_minutes", $existing?->tardiness_minutes ?? 0) }}">
                                </td>
                                <td>
                                    <input type="text" name="records[{{ $index }}][justification]" class="form-control form-control-sm"
                                           value="{{ old("records.{$index}.justification", $existing?->justification) }}" placeholder="Opcional">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i> Guardar asistencia
                </button>
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </x-card>
@elseif($sectionId)
    <x-card class="mt-3">
        <p class="text-muted mb-0">No hay alumnos matriculados activos en esta sección para el año seleccionado.</p>
    </x-card>
@endif

@endsection
