@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Curso" />
<x-alert />

<x-card title="Datos del curso">
    <form action="{{ route('academic.courses.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <div class="row">
            <div class="col-md-6"><x-form-input label="Nombre del curso" name="name" placeholder="Matemática, Comunicación..." required /></div>
            <div class="col-md-3"><x-form-input label="Código" name="code" placeholder="MAT, COM" /></div>
            <div class="col-md-3"><x-form-input label="Horas semanales" name="hours_per_week" type="number" /></div>
        </div>

        <x-form-select label="Grado (opcional)" name="grade_id" :options="$grades" placeholder="Aplica a todos los grados" />
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activo</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('academic.courses.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
