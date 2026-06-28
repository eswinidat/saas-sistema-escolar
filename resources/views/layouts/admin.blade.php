<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php $panelType = \App\Support\AdminPanel::type(); @endphp
    <title>{{ \App\Support\AdminPanel::label() }} · Mi SaaS Escolar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-themes.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary theme-{{ $panelType }}">

<div class="app-wrapper">

    @include('components.navbar')

    @include('components.sidebar')

    <main class="app-main">
        <div class="app-content p-4">
            @yield('content')
        </div>
    </main>

    @include('components.footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/admin-theme.js') }}"></script>
@stack('scripts')

</body>
</html>
