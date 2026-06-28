@extends('layouts.admin')
@section('content')
<x-page-header title="Periodos de evaluación">
    <x-slot:actions><a href="{{ route('grades.periods.create') }}" class="btn btn-primary">Nuevo periodo</a></x-slot:actions>
</x-page-header>
<x-alert />
<x-card>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Periodo</th><th>Año</th><th>Tipo</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($periods as $p)
                <tr>
                    <td>{{ $p->name }}</td><td>{{ $p->academicYear->year ?? '' }}</td><td>{{ \App\Modules\Grades\Models\GradingPeriod::TYPES[$p->type] ?? $p->type }}</td>
                    <td><form action="{{ route('grades.periods.destroy', $p) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Sin periodos.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">{{ $periods->links() }}</div>
</x-card>
@endsection
