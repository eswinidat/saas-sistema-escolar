// Modo claro / oscuro — AdminLTE compatible
(function () {
    const storageKey = 'edusaas-theme';
    const html = document.documentElement;

    function applyTheme(theme) {
        html.setAttribute('data-bs-theme', theme);
        document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
            const name = icon.getAttribute('data-lte-theme-icon');
            icon.classList.toggle('d-none', name !== theme && name !== 'auto');
        });
        const autoIcon = document.querySelector('[data-lte-theme-icon="auto"]');
        if (autoIcon && theme === 'auto') autoIcon.classList.remove('d-none');
    }

    const saved = localStorage.getItem(storageKey) || 'light';
    applyTheme(saved);

    document.querySelectorAll('[data-bs-theme-value]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const theme = btn.getAttribute('data-bs-theme-value');
            localStorage.setItem(storageKey, theme);
            applyTheme(theme);
            document.querySelectorAll('[data-bs-theme-value]').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
})();
