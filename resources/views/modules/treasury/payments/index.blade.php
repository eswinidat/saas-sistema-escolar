@extends('layouts.admin')
@section('content')
<x-page-header title="Pagos registrados"><x-slot:actions><a href="{{ route('treasury.payments.create') }}" class="btn btn-success">Registrar pago</a></x-slot:actions></x-page-header>
<x-alert />
<x-card>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Recibo</th><th>Alumno</th><th>Concepto</th><th>Monto</th><th>Fecha</th><th>Método</th><th width="100">Acciones</th></tr></thead>
        <tbody>
            @forelse($payments as $p)
                <tr>
                    <td>{{ $p->receipt_number ?? '—' }}</td>
                    <td>{{ $p->student->fullName() ?? '' }}</td>
                    <td>{{ $p->studentCharge->paymentConcept->name ?? 'Libre' }}</td>
                    <td>S/ {{ number_format($p->amount, 2) }}</td>
                    <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                    <td>{{ \App\Modules\Treasury\Models\Payment::METHODS[$p->payment_method] ?? $p->payment_method }}</td>
                    <td><a href="{{ route('billing.documents.from-payment', $p) }}" class="btn btn-sm btn-outline-primary">Facturar</a></td>
                </tr>
            @empty<tr><td colspan="7" class="text-center text-muted">Sin pagos.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $payments->links() }}
</x-card>
@endsection
