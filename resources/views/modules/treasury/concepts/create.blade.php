@extends('layouts.admin')
@section('content')
<x-page-header title="Nuevo concepto de pago" />
<x-card>
    <form action="{{ route('treasury.concepts.store') }}" method="POST">@csrf
        @include('modules.partials.school-field')
        <x-form-input label="Nombre" name="name" required />
        <x-form-input label="Código" name="code" />
        <x-form-select label="Tipo" name="type" :options="$types" value="pension" required />
        <x-form-input label="Monto por defecto (S/)" name="default_amount" type="number" step="0.01" required />
        <div class="form-check mb-3"><input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="rec"><label for="rec">Recurrente (mensual)</label></div>
        <button class="btn btn-primary">Guardar</button>
    </form>
</x-card>
@endsection
