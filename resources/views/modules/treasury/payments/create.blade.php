@extends('layouts.admin')
@section('content')
<x-page-header title="Registrar pago" />
<x-card>
    <form action="{{ route('treasury.payments.store') }}" method="POST">@csrf
        @include('modules.partials.school-field')
        <div class="mb-3"><label>Alumno</label><select name="student_id" class="form-select" required>@foreach($students as $s)<option value="{{ $s->id }}" @selected($selectedStudentId == $s->id)>{{ $s->fullName() }}</option>@endforeach</select></div>
        <div class="mb-3"><label>Cargo (opcional)</label><select name="student_charge_id" class="form-select"><option value="">Pago libre</option>@foreach($charges as $c)<option value="{{ $c->id }}">{{ $c->paymentConcept->name ?? '' }} — Saldo S/ {{ number_format($c->balance(), 2) }}</option>@endforeach</select></div>
        <x-form-input label="Monto (S/)" name="amount" type="number" step="0.01" required />
        <x-form-input label="Fecha" name="payment_date" type="date" :value="date('Y-m-d')" required />
        <x-form-select label="Método" name="payment_method" :options="$methods" value="cash" required />
        <x-form-input label="N° recibo" name="receipt_number" />
        <button class="btn btn-success">Registrar pago</button>
    </form>
</x-card>
@endsection
