<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const school = computed(() => page.props.school);

const nav = [
    { href: '/portal', label: 'Inicio', icon: '🏠', match: (url) => url === '/portal' },
    { href: '/portal/notas', label: 'Notas', icon: '📊', match: (url) => url.startsWith('/portal/notas') },
    { href: '/portal/asistencia', label: 'Asistencia', icon: '📅', match: (url) => url.startsWith('/portal/asistencia') },
    { href: '/portal/pagos', label: 'Pagos', icon: '💳', match: (url) => url.startsWith('/portal/pagos') },
];

const currentUrl = computed(() => page.url.split('?')[0]);

function isActive(item) {
    return item.match(currentUrl.value);
}
</script>

<template>
    <div class="portal-shell">
        <!-- Sidebar desktop -->
        <aside class="portal-sidebar">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white text-lg font-bold shadow-lg shadow-indigo-200">
                        {{ (school?.name || 'IE').substring(0, 2).toUpperCase() }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Portal familiar</div>
                        <div class="truncate text-sm font-bold text-slate-800">{{ school?.name || 'Mi colegio' }}</div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    class="portal-nav-link"
                    :class="{ active: isActive(item) }"
                >
                    <span class="text-lg">{{ item.icon }}</span>
                    {{ item.label }}
                </Link>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50 p-4">
                    <div class="text-xs text-slate-500">Conectado como</div>
                    <div class="font-semibold text-slate-800 truncate">{{ user?.name }}</div>
                    <Link
                        href="/logout"
                        method="post"
                        as="button"
                        class="mt-3 w-full rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm border border-slate-200 hover:bg-slate-50 transition"
                    >
                        Cerrar sesión
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="lg:pl-72 min-h-screen pb-20 lg:pb-8">
            <!-- Top bar mobile -->
            <header class="lg:hidden sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-indigo-600">Portal de Apoderados</div>
                        <div class="text-sm font-bold text-slate-800 truncate max-w-[200px]">{{ school?.name }}</div>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold">
                        {{ user?.name?.charAt(0) }}
                    </div>
                </div>
            </header>

            <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                <slot />
            </main>
        </div>

        <!-- Mobile bottom nav -->
        <nav class="portal-mobile-nav">
            <Link
                v-for="item in nav"
                :key="item.href"
                :href="item.href"
                class="portal-mobile-link"
                :class="{ active: isActive(item) }"
            >
                <span class="text-lg">{{ item.icon }}</span>
                {{ item.label }}
            </Link>
        </nav>
    </div>
</template>
