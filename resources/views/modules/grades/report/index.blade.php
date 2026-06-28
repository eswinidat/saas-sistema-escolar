@extends('layouts.admin')
@section('content')
<x-page-header title="Boleta de notas" />
<x-alert />
<x-card>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5"><select name="student_id" class="form-select"><option value="">Todos</option>@foreach($students as $s)<option value="{{ $s->id }}" @selected($studentId == $s->id)>{{ $s->fullName() }}</option>@endforeach</select></div>
        <div class="col-md-4"><select name="grading_period_id" class="form-select"><option value="">Todos</option>@foreach($periods as $p)<option value="{{ $p->id }}" @selected($periodId == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Filtrar</button></div>
    </form>
    <table class="table table-sm table-hover">
        <thead class="table-light"><tr><th>Alumno</th><th>Periodo</th><th>Curso</th><th>Competencia</th><th>Calif.</th><th>Num.</th></tr></thead>
        <tbody>
            @forelse($grades as $g)
                <tr>
                    <td>{{ $g->student->fullName() ?? '' }}</td><td>{{ $g->gradingPeriod->name ?? '' }}</td>
                    <td>{{ $g->course->name ?? '' }}</td><td>{{ $g->competency->name ?? '' }}</td>
                    <td><strong>{{ $g->achievement_level }}</strong></td><td>{{ $g->numeric_grade ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted text-center">Sin calificaciones.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $grades->links() }}
</x-card>
@endsection
