@extends('layouts.admin')
@section('content')
<x-page-header title="Configuración SUNAT / OSE" subtitle="Parámetros de facturación electrónica" />
<x-alert />
<x-card>
    <form action="{{ route('billing.settings.update') }}" method="POST">@csrf @method('PUT')
        <h6 class="text-muted">Datos del emisor</h6>
        <div class="row">
            <div class="col-md-8"><x-form-input label="Razón social" name="business_name" :value="old('business_name', $settings->business_name ?? $school->name)" required /></div>
            <div class="col-md-4"><x-form-input label="RUC" name="ruc" :value="old('ruc', $settings->ruc ?? $school->ruc)" maxlength="11" required /></div>
        </div>
        <x-form-input label="Nombre comercial" name="commercial_name" :value="old('commercial_name', $settings->commercial_name)" />
        <x-form-input label="Dirección fiscal" name="address" :value="old('address', $settings->address ?? $school->address)" />
        <x-form-input label="Ubigeo" name="ubigeo" :value="old('ubigeo', $settings->ubigeo)" maxlength="6" />

        <hr><h6 class="text-muted">Series de comprobantes</h6>
        <div class="row">
            <div class="col-md-4"><x-form-input label="Serie boletas" name="boleta_series" :value="old('boleta_series', $settings->boleta_series ?? 'B001')" required /></div>
            <div class="col-md-4"><x-form-input label="Serie facturas" name="factura_series" :value="old('factura_series', $settings->factura_series ?? 'F001')" required /></div>
            <div class="col-md-4"><x-form-input label="Serie notas crédito" name="nota_credito_series" :value="old('nota_credito_series', $settings->nota_credito_series ?? 'FC01')" required /></div>
        </div>

        <hr><h6 class="text-muted">Proveedor OSE</h6>
        <x-form-select label="Proveedor" name="ose_provider" :options="$providers" :value="old('ose_provider', $settings->ose_provider ?? 'demo')" required />
        <x-form-input label="URL API OSE" name="ose_api_url" :value="old('ose_api_url', $settings->ose_api_url)" placeholder="https://api.nubefact.com/api/v1" />
        <x-form-input label="Token API" name="ose_api_token" :value="old('ose_api_token', $settings->ose_api_token)" />
        <div class="form-check mb-3">
            <input type="checkbox" name="is_production" value="1" class="form-check-input" id="prod" @checked(old('is_production', $settings->is_production))>
            <label for="prod">Modo producción (SUNAT real)</label>
        </div>
        <button class="btn btn-primary">Guardar configuración</button>
    </form>
</x-card>
@endsection
