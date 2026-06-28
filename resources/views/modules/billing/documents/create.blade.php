@extends('layouts.admin')
@section('content')
<x-page-header title="Emitir comprobante electrónico" />
<x-alert />
<x-card>
    <form action="{{ route('billing.documents.store') }}" method="POST" id="docForm">@csrf
        <input type="hidden" name="school_id" value="{{ $selectedSchoolId }}">
        @if($payment)<input type="hidden" name="payment_id" value="{{ $payment->id }}"><input type="hidden" name="student_id" value="{{ $payment->student_id }}">@endif

        <div class="row">
            <div class="col-md-3">
                <x-form-select label="Tipo comprobante" name="document_type" :options="$types" :value="$docType" required />
            </div>
            <div class="col-md-3"><x-form-input label="Serie" name="series" :value="$series" readonly /></div>
            <div class="col-md-3"><x-form-input label="Número" name="number" :value="$number" readonly /></div>
            <div class="col-md-3"><x-form-input label="Fecha emisión" name="issue_date" type="date" :value="date('Y-m-d')" required /></div>
        </div>

        <h6 class="text-muted mt-3">Cliente / Adquirente</h6>
        <div class="row">
            <div class="col-md-2"><x-form-select label="Tipo doc." name="customer_doc_type" :options="$customerDocTypes" value="1" required /></div>
            <div class="col-md-3"><x-form-input label="Número documento" name="customer_doc_number" :value="$payment ? ($payment->student->guardians->first()->document_number ?? $payment->student->document_number) : ''" required /></div>
            <div class="col-md-7"><x-form-input label="Nombre / Razón social" name="customer_name" :value="$payment ? ($payment->student->guardians->first()->fullName() ?? $payment->student->fullName()) : ''" required /></div>
        </div>
        <x-form-input label="Dirección" name="customer_address" />

        <h6 class="text-muted mt-3">Detalle</h6>
        <div id="items">
            <div class="row item-row mb-2">
                <div class="col-md-6"><input type="text" name="items[0][description]" class="form-control" placeholder="Descripción" value="{{ $payment ? 'Pago pensión / servicio educativo' : '' }}" required></div>
                <div class="col-md-2"><input type="number" step="0.01" name="items[0][quantity]" class="form-control" value="1" required></div>
                <div class="col-md-2"><input type="number" step="0.01" name="items[0][unit_price]" class="form-control" placeholder="Precio" value="{{ $payment?->amount }}" required></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Crear comprobante</button>
        <a href="{{ route('billing.documents.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</x-card>
@endsection
