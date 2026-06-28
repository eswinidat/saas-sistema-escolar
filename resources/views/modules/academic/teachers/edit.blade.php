@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Docente" />
<x-alert />

<x-card title="Datos del docente">
    <form action="{{ route('academic.teachers.update', $teacher) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-3"><x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE']" :value="$teacher->document_type" required /></div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" :value="$teacher->document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Teléfono" name="phone" :value="$teacher->phone" /></div>
            <div class="col-md-3"><x-form-input label="Correo" name="email" type="email" :value="$teacher->email" /></div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" :value="$teacher->last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" :value="$teacher->middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" :value="$teacher->first_name" required /></div>
        </div>

        <div class="row">
            <div class="col-md-6"><x-form-input label="Especialidad" name="specialty" :value="$teacher->specialty" /></div>
            <div class="col-md-3"><x-form-input label="Fecha ingreso" name="hire_date" type="date" :value="$teacher->hire_date?->format('Y-m-d')" /></div>
            <div class="col-md-3"><x-form-select label="Estado" name="status" :options="$statuses" :value="$teacher->status" required /></div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('academic.teachers.show', $teacher) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
