@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Docente" />
<x-alert />

<x-card title="Datos del docente">
    <form action="{{ route('academic.teachers.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <div class="row">
            <div class="col-md-3"><x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE']" value="DNI" required /></div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Teléfono" name="phone" /></div>
            <div class="col-md-3"><x-form-input label="Correo" name="email" type="email" /></div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" required /></div>
        </div>

        <div class="row">
            <div class="col-md-6"><x-form-input label="Especialidad" name="specialty" placeholder="Matemática, Comunicación..." /></div>
            <div class="col-md-3"><x-form-input label="Fecha ingreso" name="hire_date" type="date" /></div>
            <div class="col-md-3"><x-form-select label="Estado" name="status" :options="$statuses" value="active" required /></div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('academic.teachers.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
