@extends('layouts.admin')
@section('content')
<x-page-header title="Registro de calificaciones" subtitle="Sistema por competencias — AD, A, B, C (MINEDU)" />
<x-alert />
<x-card title="Filtros">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Sección</label>
            <select name="section_id" class="form-select" required>
                <option value="">—</option>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}" @selected($sectionId == $s->id)>{{ $s->grade->name ?? '' }} — {{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Curso</label>
            <select name="course_id" class="form-select" required>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" @selected($courseId == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Periodo</label>
            <select name="grading_period_id" class="form-select" required>
                @foreach($periods as $p)
                    <option value="{{ $p->id }}" @selected($periodId == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="academic_year_id" value="{{ $academicYearId }}">
        <div class="col-md-2"><button class="btn btn-primary w-100">Cargar</button></div>
    </form>
</x-card>

@if($students->isNotEmpty() && $competency)
<x-card title="Calificaciones — {{ $competency->name }}" class="mt-3">
    <form action="{{ route('grades.entry.store') }}" method="POST">@csrf
        <input type="hidden" name="school_id" value="{{ $selectedSchoolId }}">
        <input type="hidden" name="section_id" value="{{ $sectionId }}">
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="grading_period_id" value="{{ $periodId }}">
        <input type="hidden" name="competency_id" value="{{ $competency->id }}">
        <table class="table table-bordered">
            <thead class="table-light"><tr><th>Alumno</th><th>Calificación literal</th><th>Nota numérica</th><th>Observaciones</th></tr></thead>
            <tbody>
                @foreach($students as $i => $student)
                    @php $ex = $existing->get($student->id); @endphp
                    <input type="hidden" name="records[{{ $i }}][student_id]" value="{{ $student->id }}">
                    <tr>
                        <td>{{ $student->fullName() }}</td>
                        <td>
                            <select name="records[{{ $i }}][achievement_level]" class="form-select form-select-sm">
                                <option value="">—</option>
                                @foreach($levels as $k => $label)
                                    <option value="{{ $k }}" @selected(old("records.{$i}.achievement_level", $ex?->achievement_level) == $k)>{{ $k }} — {{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.01" min="0" max="20" name="records[{{ $i }}][numeric_grade]" class="form-control form-control-sm" value="{{ $ex?->numeric_grade }}"></td>
                        <td><input type="text" name="records[{{ $i }}][observations]" class="form-control form-control-sm" value="{{ $ex?->observations }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-success">Guardar calificaciones</button>
    </form>
</x-card>
@elseif($sectionId && !$competency)
<x-card class="mt-3"><p class="text-warning mb-0">No hay competencia registrada para este curso. <a href="{{ route('grades.competencies.create') }}">Crear competencia</a></p></x-card>
@endif
@endsection
