@extends('layouts.admin')

@section('content')

<x-page-header title="Apoderados">
    <x-slot:actions>
        <a href="{{ route('enrollment.guardians.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Nuevo apoderado</a>
    </x-slot:actions>
</x-page-header>

<x-alert />

<x-card>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Documento</th><th>Nombre</th><th>Teléfono</th><th>Resp. económico</th><th width="120">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($guardians as $guardian)
                    <tr>
                        <td>{{ $guardian->document_type }} {{ $guardian->document_number }}</td>
                        <td>{{ $guardian->fullName() }}</td>
                        <td>{{ $guardian->phone ?? '—' }}</td>
                        <td>@if($guardian->is_economic_responsible)<span class="badge bg-success">Sí</span>@else — @endif</td>
                        <td><a href="{{ route('enrollment.guardians.edit', $guardian) }}" class="btn btn-sm btn-warning">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Sin apoderados registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $guardians->links() }}</div>
</x-card>

@endsection
