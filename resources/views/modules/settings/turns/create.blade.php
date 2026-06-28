@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Turno" />
<x-alert />

<x-card title="Datos del turno">
    <form action="{{ route('settings.turns.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')
        <x-form-input label="Nombre" name="name" placeholder="Mañana, Tarde, Completa" required />
        <div class="row">
            <div class="col-md-6"><x-form-input label="Hora inicio" name="start_time" type="time" /></div>
            <div class="col-md-6"><x-form-input label="Hora fin" name="end_time" type="time" /></div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('settings.turns.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
