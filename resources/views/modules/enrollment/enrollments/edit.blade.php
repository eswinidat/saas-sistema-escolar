@extends('layouts.admin')

@section('content')

<x-page-header title="Editar Matrícula" :subtitle="$enrollment->student->fullName()" />
<x-alert />

<x-card title="Datos de matrícula">
    <form action="{{ route('enrollment.enrollments.update', $enrollment) }}" method="POST">
        @csrf @method('PUT')

        <x-form-select label="Turno" name="turn_id" :options="$turns" :value="$enrollment->turn_id" placeholder="Opcional" />

        <div class="mb-3">
            <label class="form-label">Sección <span class="text-danger">*</span></label>
            <select name="section_id" class="form-select" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('section_id', $enrollment->section_id) == $section->id)>
                        {{ $section->grade->level->name ?? '' }} {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="N° matrícula" name="enrollment_number" :value="$enrollment->enrollment_number" /></div>
            <div class="col-md-4"><x-form-input label="Fecha" name="enrollment_date" type="date" :value="$enrollment->enrollment_date->format('Y-m-d')" required /></div>
            <div class="col-md-4"><x-form-select label="Tipo" name="type" :options="$types" :value="$enrollment->type" required /></div>
        </div>

        <x-form-select label="Estado" name="status" :options="$statuses" :value="$enrollment->status" required />
        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observations" class="form-control" rows="2">{{ old('observations', $enrollment->observations) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('enrollment.enrollments.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
