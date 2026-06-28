<header class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center gap-2">

            @role('Super Administrador')
                @php
                    $schools = \App\Models\School::where('status', true)->orderBy('name')->get();
                    $currentSchoolId = session('current_school_id');
                    $currentSchool = $schools->firstWhere('id', $currentSchoolId);
                @endphp

                <li class="nav-item">
                    <form action="{{ route('context.school.update') }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <label class="text-muted small mb-0 d-none d-md-inline">Colegio:</label>
                        <select name="school_id" class="form-select form-select-sm" style="min-width: 220px;" onchange="this.form.submit()">
                            <option value="">— Seleccionar —</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" @selected($currentSchoolId == $school->id)>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </li>

                @if($currentSchool)
                    <li class="nav-item d-none d-lg-block">
                        <span class="badge text-bg-primary">{{ $currentSchool->name }}</span>
                    </li>
                @endif
            @else
                @if(Auth::user()->school)
                    <li class="nav-item">
                        <span class="badge text-bg-secondary">{{ Auth::user()->school->name }}</span>
                    </li>
                @endif
            @endrole

            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-person-circle fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>

    </div>

</header>
