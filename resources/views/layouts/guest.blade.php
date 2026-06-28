<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión · EduSaaS Perú</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-shell">
        <section class="auth-hero">
            <div class="auth-hero-content">
                <div class="auth-brand">
                    <div class="auth-logo">E</div>
                    <div>
                        <div class="auth-brand-name">EduSaaS Perú</div>
                        <div class="auth-brand-tag">Gestión escolar multi-colegio</div>
                    </div>
                </div>
                <h1>Gestiona tu colegio con confianza</h1>
                <p>Matrícula, notas MINEDU, tesorería, facturación SUNAT y portal para apoderados — todo en una plataforma.</p>
                <ul class="auth-features">
                    <li><i class="bi bi-check-circle-fill"></i> Multi-colegio con panel Super Admin</li>
                    <li><i class="bi bi-check-circle-fill"></i> Libretas y boletas oficiales</li>
                    <li><i class="bi bi-check-circle-fill"></i> Comunicación directa con soporte</li>
                </ul>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                {{ $slot }}
            </div>
            <p class="auth-footer">&copy; {{ date('Y') }} EduSaaS Perú · Sistema ERP escolar</p>
        </section>
    </div>
</body>
</html>
