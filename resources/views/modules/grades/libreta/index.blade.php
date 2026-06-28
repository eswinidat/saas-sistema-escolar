@extends('layouts.admin')
@section('content')
<x-page-header title="Libretas de notas (PDF)" subtitle="Informe de progreso por competencias — MINEDU" />
<x-alert />
<x-card>
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label">Alumno</label>
            <select name="student_id" class="form-select" required>
                <option value="">Seleccione alumno</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}" @selected($studentId == $s->id)>{{ $s->fullName() }} ({{ $s->document_number }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Periodo de evaluación</label>
            <select name="grading_period_id" class="form-select" required>
                <option value="">Seleccione periodo</option>
                @foreach($periods as $p)
                    <option value="{{ $p->id }}" @selected($periodId == $p->id)>{{ $p->name }} ({{ $p->academicYear->year ?? '' }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" formaction="{{ route('grades.libreta.preview') }}" formtarget="_blank" class="btn btn-outline-primary flex-fill">Vista previa</button>
            <button type="submit" formaction="{{ route('grades.libreta.pdf') }}" class="btn btn-primary flex-fill">Descargar PDF</button>
        </div>
    </form>
</x-card>
@endsection
