<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
            <span class="brand-text fw-light">Mi SaaS Escolar</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @role('Super Administrador')
                <li class="nav-item">
                    <a href="{{ route('schools.index') }}" class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-building"></i>
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
                        <p>Roles</p>
                    </a>
                </li>
                @endrole

                <li class="nav-header">Configuración</li>

                <li class="nav-item {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Estructura académica <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings.academic-years.index') }}" class="nav-link {{ request()->routeIs('settings.academic-years.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Años académicos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.levels.index') }}" class="nav-link {{ request()->routeIs('settings.levels.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Niveles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.grades.index') }}" class="nav-link {{ request()->routeIs('settings.grades.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Grados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.sections.index') }}" class="nav-link {{ request()->routeIs('settings.sections.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Secciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.turns.index') }}" class="nav-link {{ request()->routeIs('settings.turns.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Turnos</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Matrícula</li>

                <li class="nav-item {{ request()->routeIs('enrollment.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('enrollment.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-mortarboard"></i>
                        <p>Estudiantes <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('enrollment.students.index') }}" class="nav-link {{ request()->routeIs('enrollment.students.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Alumnos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('enrollment.guardians.index') }}" class="nav-link {{ request()->routeIs('enrollment.guardians.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Apoderados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('enrollment.enrollments.index') }}" class="nav-link {{ request()->routeIs('enrollment.enrollments.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Matrículas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Gestión Académica</li>

                <li class="nav-item {{ request()->routeIs('academic.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('academic.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-workspace"></i>
                        <p>Académico <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('academic.teachers.index') }}" class="nav-link {{ request()->routeIs('academic.teachers.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Docentes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('academic.courses.index') }}" class="nav-link {{ request()->routeIs('academic.courses.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Cursos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('academic.assignments.index') }}" class="nav-link {{ request()->routeIs('academic.assignments.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Asignaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('academic.schedules.index') }}" class="nav-link {{ request()->routeIs('academic.schedules.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Horarios</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar-check"></i>
                        <p>Asistencia</p>
                    </a>
                </li>

                <li class="nav-header">Notas (MINEDU)</li>

                <li class="nav-item {{ request()->routeIs('grades.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Evaluación <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('grades.periods.index') }}" class="nav-link {{ request()->routeIs('grades.periods.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Periodos</p></a></li>
                        <li class="nav-item"><a href="{{ route('grades.competencies.index') }}" class="nav-link {{ request()->routeIs('grades.competencies.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Competencias</p></a></li>
                        <li class="nav-item"><a href="{{ route('grades.entry.create') }}" class="nav-link {{ request()->routeIs('grades.entry.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Registrar notas</p></a></li>
                        <li class="nav-item"><a href="{{ route('grades.report') }}" class="nav-link {{ request()->routeIs('grades.report') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Boleta</p></a></li>
                    </ul>
                </li>

                <li class="nav-header">Tesorería</li>

                <li class="nav-item {{ request()->routeIs('treasury.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('treasury.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Caja <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('treasury.concepts.index') }}" class="nav-link {{ request()->routeIs('treasury.concepts.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Conceptos</p></a></li>
                        <li class="nav-item"><a href="{{ route('treasury.charges.index') }}" class="nav-link {{ request()->routeIs('treasury.charges.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Cobros</p></a></li>
                        <li class="nav-item"><a href="{{ route('treasury.payments.index') }}" class="nav-link {{ request()->routeIs('treasury.payments.*') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Pagos</p></a></li>
                    </ul>
                </li>

                <li class="nav-header">Portal</li>

                <li class="nav-item">
                    <a href="{{ route('portal.dashboard') }}" class="nav-link" target="_blank">
                        <i class="nav-icon bi bi-phone"></i>
                        <p>Portal apoderados</p>
                    </a>
                </li>

                <li class="nav-header">Próximamente</li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled">
                        <i class="nav-icon bi bi-receipt"></i>
                        <p>Facturación SUNAT</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
