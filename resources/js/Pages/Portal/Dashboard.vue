<script setup>
import { Link, router } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

defineProps({
    students: Array,
    selectedStudentId: Number,
    stats: Object,
});
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Bienvenido al portal</h1>

        <div v-if="students?.length" class="mb-6">
            <label class="block text-sm font-medium text-slate-600 mb-1">Hijo(a)</label>
            <select
                class="rounded-lg border-slate-300 shadow-sm"
                :value="selectedStudentId"
                @change="router.get('/portal', { student_id: $event.target.value })"
            >
                <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }} — {{ s.section || 'Sin sección' }}</option>
            </select>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                <div class="text-2xl font-bold text-blue-600">{{ stats?.grades ?? 0 }}</div>
                <div class="text-sm text-slate-500">Calificaciones</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                <div class="text-2xl font-bold text-emerald-600">{{ stats?.attendance_present ?? 0 }}</div>
                <div class="text-sm text-slate-500">Asistencias</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                <div class="text-2xl font-bold text-amber-600">{{ stats?.pending_charges ?? 0 }}</div>
                <div class="text-sm text-slate-500">Pagos pendientes</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                <div class="text-2xl font-bold text-red-600">S/ {{ Number(stats?.balance ?? 0).toFixed(2) }}</div>
                <div class="text-sm text-slate-500">Deuda total</div>
            </div>
        </div>

        <div class="mt-8 grid md:grid-cols-3 gap-4">
            <Link href="/portal/notas" class="block bg-white rounded-xl p-5 shadow-sm border hover:border-blue-300 transition">
                <div class="font-semibold text-slate-800">Ver notas</div>
                <div class="text-sm text-slate-500 mt-1">Competencias y calificaciones MINEDU</div>
            </Link>
            <Link href="/portal/asistencia" class="block bg-white rounded-xl p-5 shadow-sm border hover:border-blue-300 transition">
                <div class="font-semibold text-slate-800">Asistencia</div>
                <div class="text-sm text-slate-500 mt-1">Historial diario</div>
            </Link>
            <Link href="/portal/pagos" class="block bg-white rounded-xl p-5 shadow-sm border hover:border-blue-300 transition">
                <div class="font-semibold text-slate-800">Pagos</div>
                <div class="text-sm text-slate-500 mt-1">Pensiones y estado de cuenta</div>
            </Link>
        </div>
    </div>
</template>
