@extends('layouts.admin')
@section('content')
<x-page-header title="Competencias MINEDU">
    <x-slot:actions><a href="{{ route('grades.competencies.create') }}" class="btn btn-primary">Nueva competencia</a></x-slot:actions>
</x-page-header>
<x-alert />
<x-card>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Competencia</th><th>Curso</th><th>Capacidades</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($competencies as $c)
                <tr>
                    <td>{{ $c->name }}</td><td>{{ $c->course->name ?? 'General' }}</td>
                    <td>{{ $c->capabilities->pluck('name')->join(', ') ?: '—' }}</td>
                    <td><form action="{{ route('grades.competencies.destroy', $c) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Sin competencias.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">{{ $competencies->links() }}</div>
</x-card>
@endsection
