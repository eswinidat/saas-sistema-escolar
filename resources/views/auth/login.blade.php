<x-guest-layout>
    <h2>Bienvenido</h2>
    <p class="subtitle">Ingresa a tu cuenta para continuar</p>

    @if (session('status'))
        <div class="auth-alert auth-alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-field">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@colegio.edu.pe">
            @error('email')<div class="auth-error">{{ $message }}</div>@enderror
        </div>

        <div class="auth-field">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')<div class="auth-error">{{ $message }}</div>@enderror
        </div>

        <div class="auth-row">
            <label><input type="checkbox" name="remember"> Recordarme</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color:#6366f1;text-decoration:none;">¿Olvidaste tu clave?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">Iniciar sesión</button>
    </form>

    <div class="auth-demo">
        <strong>Cuentas demo:</strong><br>
        Super Admin: admin@sistema.edu.pe<br>
        Director: director@sanmartin.edu.pe<br>
        Apoderado: padre@sanmartin.edu.pe<br>
        Contraseña: <strong>password</strong>
    </div>
</x-guest-layout>
