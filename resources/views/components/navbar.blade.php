<header class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <span class="nav-link text-muted">{{ \App\Support\AdminPanel::label() }}</span>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center gap-1">

            @php
                $chatUnread = auth()->check() ? app(\App\Services\ChatService::class)->unreadCount(auth()->user()) : 0;
            @endphp

            @hasanyrole('Super Administrador|Administrador Colegio|Secretaria')
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('chat.index') }}" title="Mensajes">
                        <i class="bi bi-chat-text"></i>
                        @if($chatUnread > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger" style="font-size:.6rem;">{{ $chatUnread }}</span>
                        @endif
                    </a>
                </li>
            @endhasanyrole

            <!-- Theme toggle -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-label="Cambiar tema">
                    <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                    <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                    <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="--bs-dropdown-min-width: 8rem">
                    <li><button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light"><i class="bi bi-sun-fill me-2"></i> Claro</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"><i class="bi bi-moon-fill me-2"></i> Oscuro</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"><i class="bi bi-circle-half me-2"></i> Auto</button></li>
                </ul>
            </li>

            @role('Super Administrador')
                @php
                    $schools = \App\Models\School::where('status', true)->orderBy('name')->get();
                    $currentSchoolId = session('current_school_id');
                    $currentSchool = $schools->firstWhere('id', $currentSchoolId);
                @endphp

                <li class="nav-item d-none d-lg-block">
                    <span class="badge panel-badge-super">Super Admin</span>
                </li>

                <li class="nav-item">
                    <form action="{{ route('context.school.update') }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <select name="school_id" class="form-select form-select-sm" style="min-width: 200px;" onchange="this.form.submit()">
                            <option value="">— Colegio —</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" @selected($currentSchoolId == $school->id)>{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </li>
            @else
                @php $panelType = \App\Support\AdminPanel::type(); @endphp
                <li class="nav-item d-none d-md-block">
                    <span class="badge panel-badge-{{ $panelType }}">
                        @if($panelType === 'teacher') Docente
                        @elseif($panelType === 'student') Estudiante
                        @else Director / Admin
                        @endif
                    </span>
                </li>
                @if(Auth::user()->school)
                    <li class="nav-item d-none d-lg-block">
                        <span class="badge text-bg-secondary">{{ Auth::user()->school->name }}</span>
                    </li>
                @endif
            @endrole

            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary py-3 px-3 rounded-top">
                        <p class="mb-0">{{ Auth::user()->name }}<small class="d-block opacity-75">{{ Auth::user()->email }}</small></p>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>

    </div>

</header>
