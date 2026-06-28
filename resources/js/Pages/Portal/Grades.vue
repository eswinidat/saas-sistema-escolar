<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

const props = defineProps({
    students: Array,
    selectedStudentId: Number,
    grades: Array,
    periods: Array,
});

const selectedPeriodId = ref(props.periods?.[0]?.id ?? '');

const levelStyle = (level) => ({
    AD: 'bg-emerald-100 text-emerald-800 ring-emerald-200',
    A: 'bg-blue-100 text-blue-800 ring-blue-200',
    B: 'bg-amber-100 text-amber-800 ring-amber-200',
    C: 'bg-red-100 text-red-800 ring-red-200',
}[level] || 'bg-slate-100 text-slate-700 ring-slate-200');

function downloadLibreta() {
    if (!props.selectedStudentId || !selectedPeriodId.value) return;
    const params = new URLSearchParams({
        student_id: props.selectedStudentId,
        grading_period_id: selectedPeriodId.value,
    });
    window.open(`/portal/libreta/pdf?${params}`, '_blank');
}
</script>

<template>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Notas y competencias</h1>
                <p class="text-slate-500 text-sm mt-1">Calificaciones oficiales según el currículo MINEDU</p>
            </div>
            <div v-if="selectedStudentId && periods?.length" class="flex items-center gap-2">
                <select v-model="selectedPeriodId" class="portal-select sm:w-48">
                    <option v-for="p in periods" :key="p.id" :value="p.id">{{ p.name }}</option>
                </select>
                <button
                    type="button"
                    class="rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-200 hover:shadow-lg transition whitespace-nowrap"
                    @click="downloadLibreta"
                >
                    📄 Libreta PDF
                </button>
            </div>
        </div>

        <select
            v-if="students?.length"
            class="portal-select max-w-md"
            :value="selectedStudentId"
            @change="router.get('/portal/notas', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div v-if="grades?.length" class="portal-table-card">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="p-4">Periodo</th>
                            <th class="p-4">Curso</th>
                            <th class="p-4">Competencia</th>
                            <th class="p-4 text-center">Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(g, i) in grades" :key="i" class="border-t border-slate-50 hover:bg-slate-50/50">
                            <td class="p-4 text-slate-600">{{ g.period }}</td>
                            <td class="p-4 font-medium text-slate-800">{{ g.course }}</td>
                            <td class="p-4 text-slate-600">{{ g.competency }}</td>
                            <td class="p-4 text-center">
                                <span
                                    v-if="g.level"
                                    class="portal-badge ring-1 ring-inset font-bold"
                                    :class="levelStyle(g.level)"
                                >
                                    {{ g.level }}
                                </span>
                                <span v-if="g.numeric" class="ml-2 text-slate-500">{{ g.numeric }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-else class="rounded-2xl bg-white border border-dashed border-slate-200 p-12 text-center">
            <div class="text-4xl mb-3">📭</div>
            <p class="text-slate-500 font-medium">Aún no hay calificaciones registradas para este periodo.</p>
        </div>

        <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-4 text-sm text-indigo-800">
            <strong>Escala MINEDU:</strong> AD = Logro destacado · A = Logro esperado · B = En proceso · C = En inicio
        </div>
    </div>
</template>
