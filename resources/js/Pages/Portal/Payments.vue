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

const statusClass = (s) => ({
    paid: 'bg-emerald-100 text-emerald-800',
    pending: 'bg-amber-100 text-amber-800',
    partial: 'bg-orange-100 text-orange-800',
    overdue: 'bg-red-100 text-red-800',
}[s] || 'bg-slate-100 text-slate-700');
</script>

<template>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Estado de pagos</h1>
            <p class="text-slate-500 text-sm mt-1">Pensiones, conceptos y saldos pendientes</p>
        </div>

        <div
            class="rounded-2xl p-6 text-white shadow-lg"
            :class="totalBalance > 0 ? 'bg-gradient-to-r from-rose-500 to-red-600' : 'bg-gradient-to-r from-emerald-500 to-teal-600'"
        >
            <div class="text-sm font-medium opacity-90">Deuda total</div>
            <div class="text-4xl font-extrabold mt-1">S/ {{ Number(totalBalance ?? 0).toFixed(2) }}</div>
            <div class="text-sm opacity-80 mt-2">
                {{ totalBalance > 0 ? 'Regulariza tus pagos para mantener la matrícula al día.' : '¡Al día! No tienes deudas pendientes.' }}
            </div>
        </div>

        <select
            v-if="students?.length"
            class="portal-select max-w-md"
            :value="selectedStudentId"
            @change="router.get('/portal/pagos', { student_id: $event.target.value })"
        >
            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>

        <div v-if="charges?.length" class="space-y-3">
            <div
                v-for="(c, i) in charges"
                :key="i"
                class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm"
            >
                <div class="flex flex-wrap justify-between gap-4">
                    <div>
                        <div class="font-bold text-slate-800">{{ c.concept }}</div>
                        <div class="text-sm text-slate-500 mt-0.5">{{ c.period }} · Vence {{ c.due_date }}</div>
                        <div class="text-xs text-slate-400 mt-1">
                            Pagado: S/ {{ c.paid.toFixed(2) }} de S/ {{ c.amount.toFixed(2) }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-extrabold" :class="c.balance > 0 ? 'text-red-600' : 'text-emerald-600'">
                            S/ {{ c.balance.toFixed(2) }}
                        </div>
                        <span class="portal-badge mt-1 font-semibold" :class="statusClass(c.status)">
                            {{ c.status_label }}
                        </span>
                    </div>
                </div>
                <div v-if="c.amount > 0" class="mt-3 h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div
                        class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 transition-all"
                        :style="{ width: `${Math.min(100, (c.paid / c.amount) * 100)}%` }"
                    />
                </div>
            </div>
        </div>

        <div v-else class="rounded-2xl bg-white border border-dashed border-slate-200 p-12 text-center">
            <div class="text-4xl mb-3">💳</div>
            <p class="text-slate-500 font-medium">No hay cargos registrados.</p>
        </div>
    </div>
</template>
