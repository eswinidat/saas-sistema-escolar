@extends('layouts.admin')
@section('content')
<x-page-header title="Generar cobro" />
<x-card>
    <form action="{{ route('treasury.charges.store') }}" method="POST">@csrf
        @include('modules.partials.school-field')
        <x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required />
        <div class="mb-3"><label>Alumno</label><select name="student_id" class="form-select" required>@foreach($students as $s)<option value="{{ $s->id }}">{{ $s->fullName() }}</option>@endforeach</select></div>
        <div class="mb-3"><label>Concepto</label><select name="payment_concept_id" class="form-select" required>@foreach($concepts as $c)<option value="{{ $c->id }}">{{ $c->name }} (S/ {{ $c->default_amount }})</option>@endforeach</select></div>
        <x-form-input label="Monto (S/)" name="amount" type="number" step="0.01" required />
        <x-form-input label="Fecha vencimiento" name="due_date" type="date" :value="date('Y-m-d')" required />
        <x-form-input label="Periodo (ej. Marzo 2026)" name="period_label" />
        <button class="btn btn-primary">Generar</button>
    </form>
</x-card>
@endsection
