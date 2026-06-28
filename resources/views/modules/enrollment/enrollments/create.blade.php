@extends('layouts.admin')

@section('content')

<x-page-header title="Nueva Matrícula" />
<x-alert />

<x-card title="Datos de matrícula">
    <form action="{{ route('enrollment.enrollments.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <div class="mb-3">
            <label class="form-label">Alumno <span class="text-danger">*</span></label>
            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                <option value="">Seleccione alumno</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id', request('student_id')) == $student->id)>
                        {{ $student->fullName() }} — {{ $student->document_number }}
                    </option>
                @endforeach
            </select>
            @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6"><x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required /></div>
            <div class="col-md-6"><x-form-select label="Turno" name="turn_id" :options="$turns" placeholder="Opcional" /></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Sección <span class="text-danger">*</span></label>
            <select name="section_id" class="form-select @error('section_id') is-invalid @enderror" required>
                <option value="">Seleccione sección</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>
                        {{ $section->academicYear->year ?? '' }} · {{ $section->grade->level->name ?? '' }} {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
            @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="N° matrícula" name="enrollment_number" /></div>
            <div class="col-md-4"><x-form-input label="Fecha" name="enrollment_date" type="date" :value="date('Y-m-d')" required /></div>
            <div class="col-md-4"><x-form-select label="Tipo" name="type" :options="$types" value="new" required /></div>
        </div>

        <x-form-select label="Estado" name="status" :options="$statuses" value="active" required />
        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observations" class="form-control" rows="2">{{ old('observations') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Registrar matrícula</button>
            <a href="{{ route('enrollment.enrollments.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
