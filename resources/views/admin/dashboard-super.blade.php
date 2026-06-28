@extends('layouts.admin')

@section('content')
<div class="app-content-header mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end mb-0">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Panel SaaS</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner"><h3>{{ $totalSchools }}</h3><p>Colegios registrados</p></div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 21h16v-2H4v2zm0-4h16v-2H4v2zm0-4h16v-2H4v2zm0-4h16V7H4v2zm0-6v2h16V3H4z"></path></svg>
            <a href="{{ route('schools.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">Gestionar <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner"><h3>{{ $totalUsers }}</h3><p>Usuarios del sistema</p></div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"></path></svg>
            <a href="{{ route('users.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">Ver usuarios <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner"><h3>{{ $chatUnread ?? 0 }}</h3><p>Mensajes sin leer</p></div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
            <a href="{{ route('chat.index') }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">Abrir chat <i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner"><h3>{{ $activeSchool ? $schoolStudents : '—' }}</h3><p>Alumnos (colegio activo)</p></div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"></path></svg>
            @if($activeSchool)
                <a href="{{ route('enrollment.students.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">Ver alumnos <i class="bi bi-arrow-right-circle"></i></a>
            @else
                <span class="small-box-footer">Seleccione colegio arriba</span>
            @endif
        </div>
    </div>
</div>

@if(!$activeSchool)
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Selecciona un colegio en la barra superior para operar sus módulos académicos y ver estadísticas detalladas.</div>
@endif

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="bi bi-buildings me-1"></i> Resumen plataforma</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fs-2 fw-bold text-primary">{{ $totalSchools }}</div>
                        <div class="text-muted small">Colegios</div>
                    </div>
                    <div class="col-4">
                        <div class="fs-2 fw-bold text-success">{{ $totalUsers }}</div>
                        <div class="text-muted small">Usuarios</div>
                    </div>
                    <div class="col-4">
                        <div class="fs-2 fw-bold text-warning">{{ $chatContacts->count() ?? 0 }}</div>
                        <div class="text-muted small">Contactos colegio</div>
                    </div>
                </div>
                <hr>
                <p class="text-muted small mb-0">Como Super Administrador puedes gestionar todos los colegios, usuarios, roles y comunicarte directamente con directores y administradores de cada institución.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4">
        <x-direct-chat
            :conversation="$chatConversation ?? null"
            :messages="$chatMessages ?? collect()"
            :contacts="$chatContacts ?? collect()"
        />
    </div>
</div>
@endsection
