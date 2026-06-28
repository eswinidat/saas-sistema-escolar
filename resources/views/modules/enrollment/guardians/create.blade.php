@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Apoderado" />
<x-alert />

<x-card title="Datos del apoderado">
    <form action="{{ route('enrollment.guardians.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <div class="row">
            <div class="col-md-3">
                <x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE']" value="DNI" required />
            </div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Teléfono" name="phone" /></div>
            <div class="col-md-3"><x-form-input label="Correo" name="email" type="email" /></div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" required /></div>
        </div>

        <x-form-input label="Dirección" name="address" />
        <x-form-input label="Ocupación" name="occupation" />

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_economic_responsible" value="1" id="is_economic_responsible">
            <label class="form-check-label" for="is_economic_responsible">Responsable económico</label>
        </div>

        <hr>
        <h6 class="text-muted">Vincular con alumno (opcional)</h6>

        <div class="mb-3">
            <label class="form-label">Alumno</label>
            <select name="student_id" class="form-select">
                <option value="">— Sin vincular —</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id', request('student_id')) == $student->id)>
                        {{ $student->fullName() }} ({{ $student->document_number }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Parentesco" name="relationship" :options="$relationships" value="apoderado" />
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary">
                    <label class="form-check-label" for="is_primary">Apoderado principal</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('enrollment.guardians.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
