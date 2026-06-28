@extends('layouts.admin')

@section('content')

<x-page-header title="Registrar Sección" />
<x-alert />

<x-card title="Datos de la sección">
    <form action="{{ route('settings.sections.store') }}" method="POST">
        @csrf
        @include('modules.partials.school-field')

        <x-form-select label="Año académico" name="academic_year_id" :options="$academicYears" required />
        <x-form-select label="Turno" name="turn_id" :options="$turns" placeholder="Opcional" />

        <div class="mb-3">
            <label class="form-label">Grado <span class="text-danger">*</span></label>
            <select name="grade_id" class="form-select @error('grade_id') is-invalid @enderror" required>
                <option value="">Seleccione grado</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" @selected(old('grade_id') == $grade->id)>
                        {{ $grade->level->name ?? '' }} — {{ $grade->name }}
                    </option>
                @endforeach
            </select>
            @error('grade_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-4"><x-form-input label="Sección" name="name" placeholder="A, B, C" required /></div>
            <div class="col-md-4"><x-form-input label="Capacidad" name="capacity" type="number" /></div>
            <div class="col-md-4"><x-form-input label="Tutor(a)" name="tutor_name" /></div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="is_active">
            <label class="form-check-label" for="is_active">Activa</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('settings.sections.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
