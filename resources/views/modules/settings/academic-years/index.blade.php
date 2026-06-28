@extends('layouts.admin')

@section('content')

<x-page-header title="Años Académicos">
    <x-slot:actions>
        <a href="{{ route('settings.academic-years.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Nuevo año
        </a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Año</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th width="160">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($academicYears as $year)
                    <tr>
                        <td>{{ $year->year }}</td>
                        <td>{{ $year->start_date?->format('d/m/Y') ?? '—' }}</td>
                        <td>{{ $year->end_date?->format('d/m/Y') ?? '—' }}</td>
                        <td>
                            @if($year->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('settings.academic-years.edit', $year) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('settings.academic-years.destroy', $year) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este año académico?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay años académicos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $academicYears->links() }}</div>
</x-card>

@endsection
