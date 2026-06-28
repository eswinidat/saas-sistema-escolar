@extends('layouts.admin')
@section('content')
<x-page-header title="Conceptos de pago"><x-slot:actions><a href="{{ route('treasury.concepts.create') }}" class="btn btn-primary">Nuevo concepto</a></x-slot:actions></x-page-header>
<x-alert />
<x-card>
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Nombre</th><th>Tipo</th><th>Monto base</th><th>Recurrente</th><th></th></tr></thead>
        <tbody>
            @forelse($concepts as $c)
                <tr><td>{{ $c->name }}</td><td>{{ \App\Modules\Treasury\Models\PaymentConcept::TYPES[$c->type] ?? $c->type }}</td><td>S/ {{ number_format($c->default_amount, 2) }}</td><td>{{ $c->is_recurring ? 'Sí' : 'No' }}</td>
                <td><form action="{{ route('treasury.concepts.destroy', $c) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td></tr>
            @empty<tr><td colspan="5" class="text-center text-muted">Sin conceptos.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $concepts->links() }}
</x-card>
@endsection
