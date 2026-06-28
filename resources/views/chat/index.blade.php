@extends('layouts.admin')

@section('content')
<div class="content-header mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6"><h1 class="m-0">Mensajes</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-end mb-0"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li><li class="breadcrumb-item active">Chat</li></ol></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <x-card title="Contactos">
            @forelse($contacts as $contact)
                <a href="{{ route('chat.start', $contact) }}" class="d-flex align-items-center gap-3 p-2 rounded text-decoration-none text-body border-bottom">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-weight:700;">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $contact->name }}</div>
                        <small class="text-muted">{{ $contact->school->name ?? 'Plataforma' }} · {{ $contact->roles->first()?->name }}</small>
                    </div>
                </a>
            @empty
                <p class="text-muted mb-0">No hay contactos disponibles.</p>
            @endforelse
        </x-card>
    </div>
    <div class="col-lg-8">
        <x-card title="Conversaciones recientes">
            @forelse($conversations as $conv)
                @php $other = $conv->otherParticipant(auth()->id()); @endphp
                <a href="{{ route('chat.show', $conv) }}" class="d-block p-3 rounded text-decoration-none text-body border mb-2 hover-bg-light">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $other?->name ?? 'Conversación' }}</strong>
                        <small class="text-muted">{{ $conv->latestMessage?->created_at?->diffForHumans() }}</small>
                    </div>
                    <small class="text-muted">{{ $conv->school?->name }}</small>
                    <div class="text-truncate small mt-1">{{ $conv->latestMessage?->body }}</div>
                </a>
            @empty
                <p class="text-muted mb-0">Aún no tienes conversaciones. Selecciona un contacto para iniciar.</p>
            @endforelse
        </x-card>
    </div>
</div>
@endsection
