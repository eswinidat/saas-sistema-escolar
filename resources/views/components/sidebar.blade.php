@php use App\Support\AdminPanel; @endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
            <span class="brand-text fw-light">{{ AdminPanel::label() }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                @if(AdminPanel::type() === 'super')
                    @include('components.sidebar-super')
                    @if(AdminPanel::canAccessSchoolModules())
                        <li class="nav-header">Colegio: {{ optional(\App\Models\School::find(session('current_school_id')))->name }}</li>
                        @include('components.sidebar-school-modules')
                    @endif
                @elseif(AdminPanel::type() === 'teacher')
                    @include('components.sidebar-teacher')
                @elseif(AdminPanel::type() === 'student')
                    @include('components.sidebar-student')
                @else
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @include('components.sidebar-school-modules')
                @endif

            </ul>
        </nav>
    </div>

</aside>
