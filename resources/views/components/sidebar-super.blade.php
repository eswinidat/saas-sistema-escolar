@php use App\Support\AdminPanel; @endphp

<li class="nav-header">Plataforma SaaS</li>

<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon bi bi-globe2"></i>
        <p>Panel global</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('schools.index') }}" class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-buildings"></i>
        <p>Colegios</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-people"></i>
        <p>Usuarios</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-shield-lock"></i>
        <p>Roles y permisos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-chat-dots"></i>
        <p>Mensajes colegios</p>
    </a>
</li>

@if(! AdminPanel::canAccessSchoolModules())
    <li class="nav-header">Colegio activo</li>
    <li class="nav-item">
        <span class="nav-link text-warning">
            <i class="nav-icon bi bi-exclamation-triangle"></i>
            <p>Seleccione un colegio arriba</p>
        </span>
    </li>
@endif
