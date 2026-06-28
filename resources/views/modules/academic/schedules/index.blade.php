@extends('layouts.admin')

@section('content')

<x-page-header title="Horarios">
    <x-slot:actions>
        <a href="{{ route('academic.schedules.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo horario</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="section_id" class="form-select" onchange="this.form.submit()">
                <option value="">Todas las secciones</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected($sectionId == $section->id)>
                        {{ $section->grade->name ?? '' }} — {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Día</th><th>Hora</th><th>Curso</th><th>Docente</th><th>Sección</th><th>Aula</th><th width="100">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ \App\Modules\Academic\Models\Schedule::DAYS[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                        <td>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                        <td>{{ $schedule->course->name ?? '—' }}</td>
                        <td>{{ $schedule->teacher->fullName() ?? '—' }}</td>
                        <td>{{ $schedule->section->grade->name ?? '' }} {{ $schedule->section->name ?? '' }}</td>
                        <td>{{ $schedule->classroom ?? '—' }}</td>
                        <td>
                            <form action="{{ route('academic.schedules.destroy', $schedule) }}" method="POST">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Sin horarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $schedules->links() }}</div>
</x-card>

@endsection
