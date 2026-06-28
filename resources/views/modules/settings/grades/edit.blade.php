@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Grado" />
<x-alert />

<x-card title="Datos del grado">
    <form action="{{ route('settings.grades.update', $grade) }}" method="POST">
        @csrf @method('PUT')
        <x-form-select label="Nivel" name="level_id" :options="$levels" :value="$grade->level_id" required />
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nombre del grado" name="name" :value="$grade->name" required /></div>
            <div class="col-md-3"><x-form-input label="Código" name="code" :value="$grade->code" /></div>
            <div class="col-md-3"><x-form-input label="Orden" name="order" type="number" :value="$grade->order" /></div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $grade->is_active))>
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('settings.grades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
