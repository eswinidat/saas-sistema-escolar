@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Turno" />
<x-alert />

<x-card title="Datos del turno">
    <form action="{{ route('settings.turns.update', $turn) }}" method="POST">
        @csrf @method('PUT')
        <x-form-input label="Nombre" name="name" :value="$turn->name" required />
        <div class="row">
            <div class="col-md-6"><x-form-input label="Hora inicio" name="start_time" type="time" :value="$turn->start_time ? substr($turn->start_time, 0, 5) : ''" /></div>
            <div class="col-md-6"><x-form-input label="Hora fin" name="end_time" type="time" :value="$turn->end_time ? substr($turn->end_time, 0, 5) : ''" /></div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $turn->is_active))>
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('settings.turns.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
