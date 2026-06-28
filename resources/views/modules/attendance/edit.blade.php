@extends('layouts.admin')

@section('content')

<x-page-header title="Editar asistencia" :subtitle="$record->student->fullName()" />
<x-alert />

<x-card title="Registro del {{ $record->date->format('d/m/Y') }}">
    <form action="{{ route('attendance.update', $record) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-4"><x-form-select label="Estado" name="status" :options="$statuses" :value="$record->status" required /></div>
            <div class="col-md-4"><x-form-input label="Hora entrada" name="check_in_time" type="time" :value="$record->check_in_time ? substr($record->check_in_time, 0, 5) : ''" /></div>
            <div class="col-md-4"><x-form-input label="Hora salida" name="check_out_time" type="time" :value="$record->check_out_time ? substr($record->check_out_time, 0, 5) : ''" /></div>
        </div>

        <x-form-input label="Tardanza (minutos)" name="tardiness_minutes" type="number" :value="$record->tardiness_minutes" />

        <div class="mb-3">
            <label class="form-label">Justificación</label>
            <textarea name="justification" class="form-control" rows="3">{{ old('justification', $record->justification) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</x-card>

@endsection
