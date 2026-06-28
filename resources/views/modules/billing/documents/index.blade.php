@extends('layouts.admin')
@section('content')
<x-page-header title="Comprobantes electrónicos">
    <x-slot:actions>
        <a href="{{ route('billing.settings.edit') }}" class="btn btn-outline-secondary me-2">Config SUNAT</a>
        <a href="{{ route('billing.documents.create') }}" class="btn btn-primary">Nuevo comprobante</a>
    </x-slot:actions>
</x-page-header>
<x-alert />
<x-card>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Comprobante</th><th>Cliente</th><th>Total</th><th>Fecha</th><th>Estado</th><th width="180">Acciones</th></tr></thead>
        <tbody>
            @forelse($documents as $doc)
                <tr>
                    <td><strong>{{ $doc->full_number }}</strong><br><small class="text-muted">{{ $doc->typeLabel() }}</small></td>
                    <td>{{ $doc->customer_name }}<br><small>{{ $doc->customer_doc_number }}</small></td>
                    <td>S/ {{ number_format($doc->total, 2) }}</td>
                    <td>{{ $doc->issue_date->format('d/m/Y') }}</td>
                    <td><span class="badge bg-{{ $doc->status === 'accepted' ? 'success' : ($doc->status === 'draft' ? 'secondary' : 'warning') }}">{{ \App\Modules\Billing\Models\ElectronicDocument::STATUSES[$doc->status] ?? $doc->status }}</span></td>
                    <td>
                        <a href="{{ route('billing.documents.show', $doc) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('billing.documents.pdf', $doc) }}" class="btn btn-sm btn-secondary">PDF</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Sin comprobantes. <a href="{{ route('billing.settings.edit') }}">Configure SUNAT</a> primero.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">{{ $documents->links() }}</div>
</x-card>
@endsection
