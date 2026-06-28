<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth?.user;

const nav = [
    { href: '/portal', label: 'Inicio' },
    { href: '/portal/notas', label: 'Notas' },
    { href: '/portal/asistencia', label: 'Asistencia' },
    { href: '/portal/pagos', label: 'Pagos' },
];
</script>

<template>
    <div class="min-h-screen">
        <header class="bg-blue-700 text-white shadow">
            <div class="max-w-5xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="font-bold text-lg">Portal de Apoderados</div>
                    <div v-if="user" class="text-blue-100 text-sm">{{ user.name }}</div>
                </div>
                <nav class="flex flex-wrap gap-2">
                    <Link
                        v-for="item in nav"
                        :key="item.href"
                        :href="item.href"
                        class="px-3 py-1.5 rounded-lg text-sm hover:bg-blue-600 transition"
                    >
                        {{ item.label }}
                    </Link>
                    <Link
                        href="/logout"
                        method="post"
                        as="button"
                        class="px-3 py-1.5 rounded-lg text-sm bg-blue-800 hover:bg-blue-900"
                    >
                        Salir
                    </Link>
                </nav>
            </div>
        </header>
        <main class="max-w-5xl mx-auto px-4 py-8">
            <slot />
        </main>
    </div>
</template>
