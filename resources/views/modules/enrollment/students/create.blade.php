@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Alumno" />
<x-alert />

<x-card title="Ficha del alumno">
    <form action="{{ route('enrollment.students.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <h6 class="text-muted mb-3">Identificación</h6>
        <div class="row">
            <div class="col-md-3">
                <x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE','PASAPORTE'=>'Pasaporte']" value="DNI" required />
            </div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Fecha nacimiento" name="birth_date" type="date" /></div>
            <div class="col-md-3">
                <x-form-select label="Género" name="gender" :options="[''=>'—','M'=>'Masculino','F'=>'Femenino']" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" required /></div>
        </div>

        <h6 class="text-muted mb-3 mt-2">Contacto y ubicación</h6>
        <div class="row">
            <div class="col-md-4"><x-form-input label="Teléfono" name="phone" /></div>
            <div class="col-md-4"><x-form-input label="Correo" name="email" type="email" /></div>
            <div class="col-md-4"><x-form-input label="Tipo sangre" name="blood_type" /></div>
        </div>
        <x-form-input label="Dirección" name="address" />
        <div class="row">
            <div class="col-md-4"><x-form-input label="Distrito" name="district" /></div>
            <div class="col-md-4"><x-form-input label="Provincia" name="province" /></div>
            <div class="col-md-4"><x-form-input label="Departamento" name="department" /></div>
        </div>

        <x-form-select label="Estado" name="status" :options="$statuses" value="active" required />

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Guardar alumno</button>
            <a href="{{ route('enrollment.students.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
