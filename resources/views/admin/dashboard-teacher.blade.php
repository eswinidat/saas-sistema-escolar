@extends('layouts.admin')

@section('content')
<div class="dashboard-hero-teacher">
    <h1 class="h3 mb-1">Panel Docente</h1>
    <p class="mb-0 opacity-75">
        @if($teacher)
            {{ $teacher->fullName() }} · {{ $school->name ?? '' }}
        @else
            Bienvenido · {{ $school->name ?? '' }}
        @endif
    </p>
</div>

<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner"><h3>{{ $assignments }}</h3><p>Asignaciones activas</p></div>
            <div class="small-box-icon"><i class="bi bi-book"></i></div>
            <a href="{{ route('academic.assignments.index') }}" class="small-box-footer">Ver asignaciones <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box text-bg-success">
            <div class="inner"><h3><i class="bi bi-calendar-check"></i></h3><p>Asistencia</p></div>
            <div class="small-box-icon"><i class="bi bi-calendar-check"></i></div>
            <a href="{{ route('attendance.index') }}" class="small-box-footer">Tomar asistencia <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box text-bg-warning">
            <div class="inner"><h3><i class="bi bi-pencil-square"></i></h3><p>Notas</p></div>
            <div class="small-box-icon"><i class="bi bi-journal-text"></i></div>
            <a href="{{ route('grades.entry.create') }}" class="small-box-footer">Registrar notas <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
</div>
@endsection
