@extends('layouts.admin')

@section('content')

<x-page-header title="Asignar Docente a Curso" />
<x-alert />

<x-card title="Nueva asignación">
    <form action="{{ route('academic.assignments.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required />

        <div class="mb-3">
            <label class="form-label">Docente <span class="text-danger">*</span></label>
            <select name="teacher_id" class="form-select" required>
                <option value="">Seleccione docente</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>{{ $teacher->fullName() }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Curso <span class="text-danger">*</span></label>
            <select name="course_id" class="form-select" required>
                <option value="">Seleccione curso</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Sección <span class="text-danger">*</span></label>
            <select name="section_id" class="form-select" required>
                <option value="">Seleccione sección</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>
                        {{ $section->academicYear->year ?? '' }} · {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-form-input label="Horas semanales" name="hours_per_week" type="number" />

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activa</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar asignación</button>
            <a href="{{ route('academic.assignments.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
