@extends('layouts.admin')

@section('content')

<x-page-header title="Secciones">
    <x-slot:actions>
        <a href="{{ route('settings.sections.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nueva sección</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Sección</th><th>Grado</th><th>Año</th><th>Turno</th><th>Tutor</th><th width="160">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($sections as $section)
                    <tr>
                        <td>{{ $section->name }}</td>
                        <td>{{ $section->grade->name ?? '—' }}</td>
                        <td>{{ $section->academicYear->year ?? '—' }}</td>
                        <td>{{ $section->turn->name ?? '—' }}</td>
                        <td>{{ $section->tutor_name ?? '—' }}</td>
                        <td>
                            <a href="{{ route('settings.sections.edit', $section) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('settings.sections.destroy', $section) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Sin secciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $sections->links() }}</div>
</x-card>

@endsection
