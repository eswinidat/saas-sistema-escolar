@extends('layouts.admin')

@section('content')

<x-page-header title="Asistencia diaria">
    <x-slot:actions>
        <a href="{{ route('attendance.take') }}" class="btn btn-success">
            <i class="bi bi-calendar-check me-1"></i> Registrar asistencia
        </a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="section_id" class="form-select">
                <option value="">Todas las secciones</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(request('section_id') == $section->id)>
                        {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Fecha</th><th>Alumno</th><th>Sección</th><th>Estado</th><th>Entrada</th><th>Salida</th><th>Tardanza</th><th width="80">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->date->format('d/m/Y') }}</td>
                        <td>{{ $record->student->fullName() ?? '—' }}</td>
                        <td>{{ $record->section->grade->name ?? '' }} {{ $record->section->name ?? '' }}</td>
                        <td>
                            @php $badge = match($record->status) { 'present' => 'success', 'absent' => 'danger', 'late' => 'warning', default => 'info' }; @endphp
                            <span class="badge bg-{{ $badge }}">{{ \App\Modules\Attendance\Models\AttendanceRecord::STATUSES[$record->status] ?? $record->status }}</span>
                        </td>
                        <td>{{ $record->check_in_time ? substr($record->check_in_time, 0, 5) : '—' }}</td>
                        <td>{{ $record->check_out_time ? substr($record->check_out_time, 0, 5) : '—' }}</td>
                        <td>{{ $record->tardiness_minutes ? $record->tardiness_minutes.' min' : '—' }}</td>
                        <td><a href="{{ route('attendance.edit', $record) }}" class="btn btn-sm btn-warning">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Sin registros de asistencia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $records->links() }}</div>
</x-card>

@endsection
