@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Nivel" />
<x-alert />

<x-card title="Datos del nivel">
    <form action="{{ route('settings.levels.update', $level) }}" method="POST">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nombre" name="name" :value="$level->name" required /></div>
            <div class="col-md-3"><x-form-input label="Código" name="code" :value="$level->code" /></div>
            <div class="col-md-3"><x-form-input label="Orden" name="order" type="number" :value="$level->order" /></div>
        </div>
        <x-form-input label="Descripción" name="description" :value="$level->description" />
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $level->is_active))>
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('settings.levels.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
