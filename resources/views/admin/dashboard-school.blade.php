@extends('layouts.admin')

@section('content')
<div class="dashboard-hero-school">
    <h1 class="h3 mb-1">{{ $school->name ?? 'Panel del colegio' }}</h1>
    <p class="mb-0 opacity-75">Gestión integral: matrícula, académico, notas, tesorería y facturación SUNAT.</p>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner"><h3>{{ $students }}</h3><p>Alumnos activos</p></div>
            <div class="small-box-icon"><i class="bi bi-mortarboard"></i></div>
            <a href="{{ route('enrollment.students.index') }}" class="small-box-footer">Ver alumnos <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner"><h3>{{ $teachers }}</h3><p>Docentes</p></div>
            <div class="small-box-icon"><i class="bi bi-person-workspace"></i></div>
            <a href="{{ route('academic.teachers.index') }}" class="small-box-footer">Ver docentes <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner"><h3>{{ $enrollments }}</h3><p>Matrículas activas</p></div>
            <div class="small-box-icon"><i class="bi bi-card-checklist"></i></div>
            <a href="{{ route('enrollment.enrollments.index') }}" class="small-box-footer">Ver matrículas <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner"><h3>{{ $pendingCharges }}</h3><p>Cobros pendientes</p></div>
            <div class="small-box-icon"><i class="bi bi-cash-coin"></i></div>
            <a href="{{ route('treasury.charges.index') }}" class="small-box-footer">Ir a tesorería <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-journal-text text-primary"></i> Notas MINEDU</h5>
                <p class="text-muted small">Registro por competencias y libretas PDF.</p>
                <a href="{{ route('grades.entry.create') }}" class="btn btn-sm btn-outline-primary">Registrar notas</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-receipt text-success"></i> Facturación SUNAT</h5>
                <p class="text-muted small">Boletas y facturas electrónicas.</p>
                <a href="{{ route('billing.documents.index') }}" class="btn btn-sm btn-outline-success">Comprobantes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-phone text-info"></i> Portal apoderados</h5>
                <p class="text-muted small">Vista que ven los padres de familia.</p>
                <a href="{{ route('portal.dashboard') }}" target="_blank" class="btn btn-sm btn-outline-info">Abrir portal</a>
            </div>
        </div>
    </div>
</div>
@endsection
