@extends('layouts.admin')
@section('content')
<x-page-header title="Cobros a alumnos">
    <x-slot:actions><a href="{{ route('treasury.charges.create') }}" class="btn btn-primary">Generar cobro</a></x-slot:actions>
    <x-slot:subtitle>Morosidad total vencida: S/ {{ number_format($overdueTotal, 2) }}</x-slot:subtitle>
</x-page-header>
<x-alert />
<x-card>
    <form method="GET" class="mb-3"><select name="status" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
        <option value="">Todos los estados</option>
        @foreach(\App\Modules\Treasury\Models\StudentCharge::STATUSES as $k => $l)
            <option value="{{ $k }}" @selected(request('status')==$k)>{{ $l }}</option>
        @endforeach
    </select></form>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Alumno</th><th>Concepto</th><th>Monto</th><th>Pagado</th><th>Vence</th><th>Estado</th></tr></thead>
        <tbody>
            @forelse($charges as $c)
                <tr>
                    <td>{{ $c->student->fullName() ?? '' }}</td><td>{{ $c->paymentConcept->name ?? '' }}</td>
                    <td>S/ {{ number_format($c->amount, 2) }}</td><td>S/ {{ number_format($c->paid_amount, 2) }}</td>
                    <td>{{ $c->due_date->format('d/m/Y') }}</td>
                    <td><span class="badge bg-secondary">{{ \App\Modules\Treasury\Models\StudentCharge::STATUSES[$c->status] ?? $c->status }}</span></td>
                </tr>
            @empty<tr><td colspan="6" class="text-center text-muted">Sin cobros.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $charges->links() }}
</x-card>
@endsection
