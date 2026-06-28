@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Apoderado" />
<x-alert />

<x-card title="Datos del apoderado">
    <form action="{{ route('enrollment.guardians.update', $guardian) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-3">
                <x-form-select label="Tipo documento" name="document_type" :options="['DNI'=>'DNI','CE'=>'CE']" :value="$guardian->document_type" required />
            </div>
            <div class="col-md-3"><x-form-input label="Número" name="document_number" :value="$guardian->document_number" required /></div>
            <div class="col-md-3"><x-form-input label="Teléfono" name="phone" :value="$guardian->phone" /></div>
            <div class="col-md-3"><x-form-input label="Correo" name="email" type="email" :value="$guardian->email" /></div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Apellido paterno" name="last_name" :value="$guardian->last_name" required /></div>
            <div class="col-md-4"><x-form-input label="Apellido materno" name="middle_name" :value="$guardian->middle_name" /></div>
            <div class="col-md-4"><x-form-input label="Nombres" name="first_name" :value="$guardian->first_name" required /></div>
        </div>

        <x-form-input label="Dirección" name="address" :value="$guardian->address" />
        <x-form-input label="Ocupación" name="occupation" :value="$guardian->occupation" />

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_economic_responsible" value="1" id="is_economic_responsible" @checked(old('is_economic_responsible', $guardian->is_economic_responsible))>
            <label class="form-check-label" for="is_economic_responsible">Responsable económico</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('enrollment.guardians.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
