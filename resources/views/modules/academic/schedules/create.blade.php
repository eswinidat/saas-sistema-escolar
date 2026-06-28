@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Horario" />
<x-alert />

<x-card title="Bloque horario">
    <form action="{{ route('academic.schedules.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required />

        <div class="mb-3">
            <label class="form-label">Sección <span class="text-danger">*</span></label>
            <select name="section_id" class="form-select" required>
                <option value="">Seleccione sección</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>
                        {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Curso <span class="text-danger">*</span></label>
                    <select name="course_id" class="form-select" required>
                        <option value="">Seleccione curso</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Docente <span class="text-danger">*</span></label>
                    <select name="teacher_id" class="form-select" required>
                        <option value="">Seleccione docente</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>{{ $teacher->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-select label="Día" name="day_of_week" :options="$days" required /></div>
            <div class="col-md-3"><x-form-input label="Hora inicio" name="start_time" type="time" required /></div>
            <div class="col-md-3"><x-form-input label="Hora fin" name="end_time" type="time" required /></div>
            <div class="col-md-2"><x-form-input label="Aula" name="classroom" /></div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Guardar horario</button>
            <a href="{{ route('academic.schedules.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
