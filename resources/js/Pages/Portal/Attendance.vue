<script setup>
import { router } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

defineProps({
    students: Array,
    selectedStudentId: Number,
    records: Array,
});

const statusClass = (s) => ({
    present: 'bg-emerald-100 text-emerald-800 ring-emerald-200',
    absent: 'bg-red-100 text-red-800 ring-red-200',
    late: 'bg-amber-100 text-amber-800 ring-amber-200',
    justified: 'bg-blue-100 text-blue-800 ring-blue-200',
    excused: 'bg-blue-100 text-blue-800 ring-blue-200',
}[s] || 'bg-slate-100 text-slate-700 ring-slate-200');

const statusIcon = (s) => ({
    present: '✅',
    absent: '❌',
    late: '⏰',
    justified: '📝',
    excused: '📝',
}[s] || '•');
</script>

<template>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Asistencia</h1>
            <p class="text-slate-500 text-sm mt-1">Historial de asistencia diaria de tu hijo(a)</p>
        </div>

        <select
            v-if="students?.length"
            class="portal-select max-w-md"
            :value="selectedStudentId"
            @change="router.get('/portal/asistencia', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div v-if="records?.length" class="space-y-3">
            <div
                v-for="(r, i) in records"
                :key="i"
                class="flex items-center justify-between bg-white rounded-2xl p-4 border border-slate-100 shadow-sm hover:shadow-md transition"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-50 text-lg">
                        {{ statusIcon(r.status) }}
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800">{{ r.date }}</div>
                        <div v-if="r.check_in" class="text-sm text-slate-500">Entrada: {{ r.check_in }}</div>
                    </div>
                </div>
                <span class="portal-badge ring-1 ring-inset font-semibold" :class="statusClass(r.status)">
                    {{ r.label }}
                </span>
            </div>
        </div>

        <div v-else class="rounded-2xl bg-white border border-dashed border-slate-200 p-12 text-center">
            <div class="text-4xl mb-3">📅</div>
            <p class="text-slate-500 font-medium">Sin registros de asistencia disponibles.</p>
        </div>
    </div>
</template>
