<script setup>
import { router } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

defineProps({
    students: Array,
    selectedStudentId: Number,
    grades: Array,
});
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Notas y competencias</h1>

        <select
            v-if="students?.length"
            class="mb-6 rounded-lg border-slate-300"
            :value="selectedStudentId"
            @change="router.get('/portal/notas', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div v-if="grades?.length" class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="p-3">Periodo</th>
                        <th class="p-3">Curso</th>
                        <th class="p-3">Competencia</th>
                        <th class="p-3">Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(g, i) in grades" :key="i" class="border-t">
                        <td class="p-3">{{ g.period }}</td>
                        <td class="p-3">{{ g.course }}</td>
                        <td class="p-3">{{ g.competency }}</td>
                        <td class="p-3">
                            <span v-if="g.level" class="font-bold text-blue-700">{{ g.level }}</span>
                            <span v-if="g.numeric" class="text-slate-600">{{ g.numeric }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p v-else class="text-slate-500">No hay calificaciones registradas.</p>
    </div>
</template>
