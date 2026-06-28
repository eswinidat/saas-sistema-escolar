<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Logo -->
    <div class="sidebar-brand">

        <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">

            <span class="brand-text fw-light">
                Mi SaaS Escolar
            </span>

        </a>

    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu">

                <!-- Dashboard -->

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-speedometer2"></i>

                        <p>Dashboard</p>

                    </a>

                </li>

                <!-- Colegios -->
                @role('Super Administrador')
                <li class="nav-item">

                    <a href="{{ route('schools.index') }}"
                       class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-building"></i>

                        <p>Colegios</p>

                    </a>

                </li>
                @endrole

                @role('Super Administrador')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                @endrole

                <!-- Usuarios -->

                <li class="nav-item">

                    <a href="#"
                       class="nav-link disabled">

                        <i class="nav-icon bi bi-people"></i>

                        <p>Usuarios</p>

                    </a>

                </li>
                @role('Super Administrador')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <p>Roles</p>
                    </a>
                </li>
                @endrole

                <!-- Estudiantes -->

                <li class="nav-item">

                    <a href="#"
                       class="nav-link disabled">

                        <i class="nav-icon bi bi-mortarboard"></i>

                        <p>Estudiantes</p>

                    </a>

                </li>

                <!-- Docentes -->

                <li class="nav-item">

                    <a href="#"
                       class="nav-link disabled">

                        <i class="nav-icon bi bi-person-workspace"></i>

                        <p>Docentes</p>

                    </a>

                </li>

                <!-- Cursos -->

                <li class="nav-item">

                    <a href="#"
                       class="nav-link disabled">

                        <i class="nav-icon bi bi-book"></i>

                        <p>Cursos</p>

                    </a>

                </li>

                <!-- Configuración -->

                <li class="nav-item">

                    <a href="#"
                       class="nav-link disabled">

                        <i class="nav-icon bi bi-gear"></i>

                        <p>Configuración</p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>