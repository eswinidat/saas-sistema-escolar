@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Año Académico" />

<x-alert />

<x-card title="Datos del año académico">
    <form action="{{ route('settings.academic-years.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <div class="row">
            <div class="col-md-4">
                <x-form-input label="Año escolar" name="year" placeholder="2026 o 2025-2026" required />
            </div>
            <div class="col-md-4">
                <x-form-input label="Fecha de inicio" name="start_date" type="date" />
            </div>
            <div class="col-md-4">
                <x-form-input label="Fecha de fin" name="end_date" type="date" />
            </div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active'))>
            <label class="form-check-label" for="is_active">Marcar como año activo</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('settings.academic-years.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
