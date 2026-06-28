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
    present: 'bg-emerald-100 text-emerald-800',
    absent: 'bg-red-100 text-red-800',
    late: 'bg-amber-100 text-amber-800',
    justified: 'bg-blue-100 text-blue-800',
}[s] || 'bg-slate-100 text-slate-800');
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Asistencia</h1>

        <select
            v-if="students?.length"
            class="mb-6 rounded-lg border-slate-300"
            :value="selectedStudentId"
            @change="router.get('/portal/asistencia', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div class="space-y-2">
            <div v-for="(r, i) in records" :key="i" class="bg-white rounded-lg p-4 border flex justify-between items-center">
                <div>
                    <div class="font-medium">{{ r.date }}</div>
                    <div v-if="r.check_in" class="text-sm text-slate-500">Entrada: {{ r.check_in }}</div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium" :class="statusClass(r.status)">{{ r.label }}</span>
            </div>
            <p v-if="!records?.length" class="text-slate-500">Sin registros de asistencia.</p>
        </div>
    </div>
</template>
