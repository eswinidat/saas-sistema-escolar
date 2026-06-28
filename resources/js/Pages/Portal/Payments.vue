<script setup>
import { router } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';

defineOptions({ layout: PortalLayout });

defineProps({
    students: Array,
    selectedStudentId: Number,
    charges: Array,
    totalBalance: Number,
});
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Estado de pagos</h1>
        <p class="text-red-600 font-semibold mb-6">Deuda total: S/ {{ Number(totalBalance ?? 0).toFixed(2) }}</p>

        <select
            v-if="students?.length"
            class="mb-6 rounded-lg border-slate-300"
            :value="selectedStudentId"
            @change="router.get('/portal/pagos', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div class="space-y-3">
            <div v-for="(c, i) in charges" :key="i" class="bg-white rounded-xl p-4 border">
                <div class="flex justify-between">
                    <div>
                        <div class="font-semibold">{{ c.concept }}</div>
                        <div class="text-sm text-slate-500">{{ c.period }} · Vence {{ c.due_date }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold">S/ {{ c.balance.toFixed(2) }}</div>
                        <div class="text-xs text-slate-500">{{ c.status_label }}</div>
                    </div>
                </div>
            </div>
            <p v-if="!charges?.length" class="text-slate-500">No hay cargos registrados.</p>
        </div>
    </div>
</template>
