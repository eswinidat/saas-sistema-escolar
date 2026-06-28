@extends('layouts.admin')
@section('content')
<x-page-header title="Nuevo periodo" />
<x-alert />
<x-card>
    <form action="{{ route('grades.periods.store') }}" method="POST">@csrf
        @include('modules.partials.school-field')
        <x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required />
        <div class="row">
            <div class="col-md-4"><x-form-input label="Nombre" name="name" placeholder="I Bimestre" required /></div>
            <div class="col-md-4"><x-form-input label="Número" name="number" type="number" value="1" required /></div>
            <div class="col-md-4"><x-form-select label="Tipo" name="type" :options="$types" value="bimester" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Inicio" name="start_date" type="date" /></div>
            <div class="col-md-6"><x-form-input label="Fin" name="end_date" type="date" /></div>
        </div>
        <button class="btn btn-primary mt-3">Guardar</button>
        <a href="{{ route('grades.periods.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</x-card>
@endsection
