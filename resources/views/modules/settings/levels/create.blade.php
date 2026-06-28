@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Nivel" />
<x-alert />

<x-card title="Datos del nivel">
    <form action="{{ route('settings.levels.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nombre" name="name" placeholder="Inicial, Primaria, Secundaria" required /></div>
            <div class="col-md-3"><x-form-input label="Código" name="code" /></div>
            <div class="col-md-3"><x-form-input label="Orden" name="order" type="number" value="0" /></div>
        </div>
        <x-form-input label="Descripción" name="description" />
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('settings.levels.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
