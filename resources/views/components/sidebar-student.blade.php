<li class="nav-header">Mi espacio</li>

<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon bi bi-house-door"></i>
        <p>Inicio</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('grades.report') }}" class="nav-link {{ request()->routeIs('grades.report') ? 'active' : '' }}">
        <i class="nav-icon bi bi-journal-text"></i>
        <p>Mis notas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-calendar-check"></i>
        <p>Mi asistencia</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('academic.schedules.index') }}" class="nav-link {{ request()->routeIs('academic.schedules.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-clock"></i>
        <p>Mi horario</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('portal.dashboard') }}" class="nav-link" target="_blank">
        <i class="nav-icon bi bi-box-arrow-up-right"></i>
        <p>Vista apoderado</p>
    </a>
</li>
