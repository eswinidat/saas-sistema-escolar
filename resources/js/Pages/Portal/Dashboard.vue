<script setup>
import { Link, router } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

const props = defineProps({
    students: Array,
    selectedStudentId: Number,
    selectedStudent: Object,
    stats: Object,
    school: Object,
    greeting: String,
});

const statCards = [
    { key: 'grades', label: 'Calificaciones', icon: '📊', gradient: 'from-indigo-500 to-violet-600' },
    { key: 'attendance_present', label: 'Días presente', icon: '✅', gradient: 'from-emerald-500 to-teal-600' },
    { key: 'pending_charges', label: 'Pagos pendientes', icon: '⏳', gradient: 'from-amber-500 to-orange-500' },
];

const quickLinks = [
    { href: '/portal/notas', title: 'Ver notas', desc: 'Competencias y calificaciones MINEDU', icon: '📚', color: 'bg-indigo-100 text-indigo-700' },
    { href: '/portal/asistencia', title: 'Asistencia', desc: 'Historial diario de tu hijo(a)', icon: '📅', color: 'bg-emerald-100 text-emerald-700' },
    { href: '/portal/pagos', title: 'Estado de pagos', desc: 'Pensiones y deudas pendientes', icon: '💰', color: 'bg-amber-100 text-amber-700' },
];

function initials(name) {
    if (!name) return '?';
    return name.split(' ').slice(0, 2).map((w) => w[0]).join('').toUpperCase();
}
</script>

<template>
    <div class="space-y-8">
        <!-- Hero -->
        <section class="portal-hero">
            <div class="relative z-10">
                <p class="text-indigo-100 text-sm font-medium mb-1">{{ greeting || 'Bienvenido' }}</p>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                    Seguimiento escolar en tiempo real
                </h1>
                <p class="text-indigo-100/90 text-sm sm:text-base max-w-xl">
                    Consulta notas, asistencia y pagos de {{ school?.name || 'tu colegio' }} desde un solo lugar.
                </p>
            </div>
        </section>

        <!-- Student selector -->
        <section v-if="students?.length" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div
                    v-if="selectedStudent"
                    class="flex items-center gap-4 flex-1"
                >
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white text-lg font-bold shadow-lg">
                        {{ initials(selectedStudent.name) }}
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">Estudiante</div>
                        <div class="text-lg font-bold text-slate-800">{{ selectedStudent.name }}</div>
                        <div class="text-sm text-slate-500">{{ selectedStudent.section || 'Sin sección asignada' }}</div>
                    </div>
                </div>
                <div class="sm:w-72">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Cambiar hijo(a)</label>
                    <select
                        class="portal-select"
                        :value="selectedStudentId"
                        @change="router.get('/portal', { student_id: $event.target.value })"
                    >
                        <option v-for="s in students" :key="s.id" :value="s.id">
                            {{ s.name }} — {{ s.section || 'Sin sección' }}
                        </option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                v-for="card in statCards"
                :key="card.key"
                class="portal-stat-card"
                :class="`bg-gradient-to-br ${card.gradient}`"
            >
                <div class="relative z-10">
                    <div class="text-3xl font-extrabold">{{ stats?.[card.key] ?? 0 }}</div>
                    <div class="text-sm font-medium opacity-90 mt-1">{{ card.label }}</div>
                </div>
                <span class="stat-icon">{{ card.icon }}</span>
            </div>
            <div class="portal-stat-card bg-gradient-to-br from-rose-500 to-red-600 col-span-2 lg:col-span-1">
                <div class="relative z-10">
                    <div class="text-3xl font-extrabold">S/ {{ Number(stats?.balance ?? 0).toFixed(2) }}</div>
                    <div class="text-sm font-medium opacity-90 mt-1">Deuda total</div>
                </div>
                <span class="stat-icon">💳</span>
            </div>
        </section>

        <!-- Quick links -->
        <section>
            <h2 class="text-lg font-bold text-slate-800 mb-4">Accesos rápidos</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                <Link
                    v-for="link in quickLinks"
                    :key="link.href"
                    :href="link.href"
                    class="portal-quick-card group"
                >
                    <div class="quick-icon mb-4" :class="link.color">{{ link.icon }}</div>
                    <div class="font-bold text-slate-800 group-hover:text-indigo-700 transition">{{ link.title }}</div>
                    <div class="text-sm text-slate-500 mt-1">{{ link.desc }}</div>
                    <div class="absolute bottom-4 right-4 text-indigo-400 opacity-0 group-hover:opacity-100 transition">→</div>
                </Link>
            </div>
        </section>

        <!-- Trust strip -->
        <section class="rounded-2xl bg-white border border-slate-100 p-5 flex flex-wrap items-center gap-4 text-sm text-slate-600">
            <span class="inline-flex items-center gap-2 font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full">
                ✓ Datos oficiales del colegio
            </span>
            <span>Calificaciones alineadas al currículo MINEDU</span>
            <span class="text-slate-300 hidden sm:inline">|</span>
            <span>Información actualizada al instante</span>
        </section>
    </div>
</template>
