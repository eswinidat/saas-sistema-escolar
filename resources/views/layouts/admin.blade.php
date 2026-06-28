<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sistema</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                       data-lte-toggle="sidebar"
                       href="#"
                       role="button">
                        ☰
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Administrador</span>
                </li>
            </ul>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
                <span class="brand-text fw-light">
                    Mi Sistema
                </span>
            </a>
        </div>

        <div class="sidebar-wrapper">

            <nav class="mt-2">

                <ul class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link active">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('schools.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-buildings"></i>
                            <p>Colegios</p>
                        </a>
                    </li>

                </ul>

            </nav>

        </div>

    </aside>

    <!-- Contenido -->
    <main class="app-main">

        <div class="app-content p-4">

            @yield('content')

        </div>

    </main>

    <!-- Footer -->
    <footer class="app-footer text-center py-3">
        <strong>Mi Sistema © {{ date('Y') }}</strong>
    </footer>

</div>

<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>