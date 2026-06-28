<li class="nav-header">Mi aula</li>

<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon bi bi-speedometer2"></i>
        <p>Mi panel</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-calendar-check"></i>
        <p>Tomar asistencia</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('grades.entry.create') }}" class="nav-link {{ request()->routeIs('grades.entry.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-pencil-square"></i>
        <p>Registrar notas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('grades.report') }}" class="nav-link {{ request()->routeIs('grades.report') ? 'active' : '' }}">
        <i class="nav-icon bi bi-journal-text"></i>
        <p>Consultar boletas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('academic.schedules.index') }}" class="nav-link {{ request()->routeIs('academic.schedules.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-clock"></i>
        <p>Horarios</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('academic.assignments.index') }}" class="nav-link {{ request()->routeIs('academic.assignments.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-person-workspace"></i>
        <p>Mis asignaciones</p>
    </a>
</li>
