@extends('layouts.admin')

@section('content')
<div class="dashboard-hero-student">
    <h1 class="h3 mb-1">Hola, {{ $user->name }}</h1>
    <p class="mb-0 opacity-75">{{ $school->name ?? 'Tu colegio' }} — Consulta tus notas, asistencia y horario.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center py-5">
                <i class="bi bi-journal-text display-4 text-warning"></i>
                <h5 class="mt-3">Mis notas</h5>
                <p class="text-muted small">Calificaciones por competencias MINEDU</p>
                <a href="{{ route('grades.report') }}" class="btn btn-warning">Ver notas</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-check display-4 text-primary"></i>
                <h5 class="mt-3">Mi asistencia</h5>
                <p class="text-muted small">Historial de asistencia diaria</p>
                <a href="{{ route('attendance.index') }}" class="btn btn-primary">Ver asistencia</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center py-5">
                <i class="bi bi-clock display-4 text-success"></i>
                <h5 class="mt-3">Mi horario</h5>
                <p class="text-muted small">Clases y horarios de la semana</p>
                <a href="{{ route('academic.schedules.index') }}" class="btn btn-success">Ver horario</a>
            </div>
        </div>
    </div>
</div>
@endsection
