@extends('layouts.admin')

@section('content')

<x-page-header title="Turnos / Jornadas">
    <x-slot:actions>
        <a href="{{ route('settings.turns.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo turno</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Nombre</th><th>Horario</th><th>Estado</th><th width="160">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($turns as $turn)
                    <tr>
                        <td>{{ $turn->name }}</td>
                        <td>
                            @if($turn->start_time && $turn->end_time)
                                {{ \Illuminate\Support\Str::of($turn->start_time)->substr(0,5) }} - {{ \Illuminate\Support\Str::of($turn->end_time)->substr(0,5) }}
                            @else — @endif
                        </td>
                        <td><span class="badge bg-{{ $turn->is_active ? 'success' : 'secondary' }}">{{ $turn->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td>
                            <a href="{{ route('settings.turns.edit', $turn) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('settings.turns.destroy', $turn) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Sin turnos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $turns->links() }}</div>
</x-card>

@endsection
