@extends('layouts.admin')
@section('content')
<x-page-header title="Registrar competencia" />
<x-alert />
<x-card>
    <form action="{{ route('grades.competencies.store') }}" method="POST">@csrf
        @include('modules.partials.school-field')
        <x-form-select label="Curso" name="course_id" :options="$courses" placeholder="General" />
        <x-form-input label="Competencia" name="name" required />
        <x-form-input label="Código" name="code" />
        <div class="mb-3">
            <label class="form-label">Capacidades (una por línea)</label>
            <textarea name="capabilities[]" class="form-control mb-2" rows="2" placeholder="Capacidad 1"></textarea>
            <textarea name="capabilities[]" class="form-control mb-2" rows="2" placeholder="Capacidad 2"></textarea>
            <textarea name="capabilities[]" class="form-control" rows="2" placeholder="Capacidad 3"></textarea>
        </div>
        <button class="btn btn-primary">Guardar</button>
    </form>
</x-card>
@endsection
