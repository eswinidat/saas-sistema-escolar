@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Grado" />
<x-alert />

<x-card title="Datos del grado">
    <form action="{{ route('settings.grades.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')
        <x-form-select label="Nivel" name="level_id" :options="$levels" required />
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nombre del grado" name="name" placeholder="1ro, 2do, 3ro..." required /></div>
            <div class="col-md-3"><x-form-input label="Código" name="code" /></div>
            <div class="col-md-3"><x-form-input label="Orden" name="order" type="number" value="0" /></div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activo</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('settings.grades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
