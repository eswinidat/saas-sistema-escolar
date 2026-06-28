@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Alumno" />
<x-alert />

<x-card title="Ficha del alumno">
    <form action="{{ route('enrollment.students.update', $student) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-3">
                <x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE','PASAPORTE'=>'Pasaporte']" :value="$student->document_type" required />
            </div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" :value="$student->document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Fecha nacimiento" name="birth_date" type="date" :value="$student->birth_date?->format('Y-m-d')" /></div>
            <div class="col-md-3">
                <x-form-select label="Género" name="gender" :options="[''=>'—','M'=>'Masculino','F'=>'Femenino']" :value="$student->gender" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" :value="$student->last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" :value="$student->middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" :value="$student->first_name" required /></div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Teléfono" name="phone" :value="$student->phone" /></div>
            <div class="col-md-4"><x-form-input label="Correo" name="email" type="email" :value="$student->email" /></div>
            <div class="col-md-4"><x-form-input label="Tipo sangre" name="blood_type" :value="$student->blood_type" /></div>
        </div>

        <x-form-input label="Dirección" name="address" :value="$student->address" />
        <div class="row">
            <div class="col-md-4"><x-form-input label="Distrito" name="district" :value="$student->district" /></div>
            <div class="col-md-4"><x-form-input label="Provincia" name="province" :value="$student->province" /></div>
            <div class="col-md-4"><x-form-input label="Departamento" name="department" :value="$student->department" /></div>
        </div>

        <x-form-select label="Estado" name="status" :options="$statuses" :value="$student->status" required />

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('enrollment.students.show', $student) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
