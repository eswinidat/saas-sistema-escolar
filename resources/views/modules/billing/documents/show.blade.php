@extends('layouts.admin')
@section('content')
<x-page-header :title="$document->full_number" :subtitle="$document->typeLabel()">
    <x-slot:actions>
        <a href="{{ route('billing.documents.pdf', $document) }}" class="btn btn-secondary">Descargar PDF</a>
        @if($document->status === 'draft')
            <form action="{{ route('billing.documents.send', $document) }}" method="POST" class="d-inline">@csrf
                <button class="btn btn-success">Enviar a SUNAT</button>
            </form>
        @endif
    </x-slot:actions>
</x-page-header>
<x-alert />
<div class="row">
    <div class="col-md-6">
        <x-card title="Cliente">
            <dl class="row mb-0">
                <dt class="col-4">Nombre</dt><dd class="col-8">{{ $document->customer_name }}</dd>
                <dt class="col-4">Documento</dt><dd class="col-8">{{ $document->customer_doc_number }}</dd>
                <dt class="col-4">Estado</dt><dd class="col-8"><span class="badge bg-secondary">{{ \App\Modules\Billing\Models\ElectronicDocument::STATUSES[$document->status] ?? $document->status }}</span></dd>
            </dl>
        </x-card>
    </div>
    <div class="col-md-6">
        <x-card title="Totales">
            <dl class="row mb-0">
                <dt class="col-4">Subtotal</dt><dd class="col-8">S/ {{ number_format($document->subtotal, 2) }}</dd>
                <dt class="col-4">IGV 18%</dt><dd class="col-8">S/ {{ number_format($document->igv, 2) }}</dd>
                <dt class="col-4">Total</dt><dd class="col-8"><strong>S/ {{ number_format($document->total, 2) }}</strong></dd>
            </dl>
        </x-card>
    </div>
</div>
<x-card title="Detalle" class="mt-3">
    <table class="table table-sm mb-0">
        <thead><tr><th>Descripción</th><th>Cant.</th><th>P.Unit</th><th>Total</th></tr></thead>
        <tbody>@foreach($document->items as $item)<tr><td>{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>S/ {{ number_format($item->unit_price,2) }}</td><td>S/ {{ number_format($item->total,2) }}</td></tr>@endforeach</tbody>
    </table>
</x-card>
@if($document->sunat_response)
<x-card title="Respuesta SUNAT" class="mt-3"><p class="mb-0">{{ $document->sunat_response }}</p>@if($document->qr_data)<pre class="mt-2 small">{{ $document->qr_data }}</pre>@endif</x-card>
@endif
@endsection
