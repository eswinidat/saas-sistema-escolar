@props(['conversation' => null, 'messages' => collect(), 'contacts' => collect(), 'other' => null])

<div class="card direct-chat direct-chat-primary h-100">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-chat-dots me-1"></i> Chat directo</h3>
        <div class="card-tools">
            @if($conversation)
                <span class="badge text-bg-primary">{{ $messages->count() }}</span>
            @endif
            <a href="{{ route('chat.index') }}" class="btn btn-tool btn-sm"><i class="bi bi-arrows-fullscreen"></i></a>
        </div>
    </div>
    <div class="card-body">
        @if(!$conversation && $contacts->isNotEmpty())
            <p class="text-muted small mb-2">Seleccione un contacto del colegio:</p>
            <div class="list-group list-group-flush mb-3" style="max-height:120px;overflow-y:auto;">
                @foreach($contacts->take(5) as $contact)
                    <a href="{{ route('chat.start', $contact) }}" class="list-group-item list-group-item-action py-2 small">
                        <strong>{{ $contact->name }}</strong>
                        <span class="text-muted"> — {{ $contact->school->name ?? '' }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="direct-chat-messages" style="height:280px;overflow-y:auto;">
            @forelse($messages as $msg)
                <div class="direct-chat-msg {{ $msg->user_id === auth()->id() ? 'end' : '' }}">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name {{ $msg->user_id === auth()->id() ? 'float-end' : 'float-start' }}">{{ $msg->user->name }}</span>
                        <span class="direct-chat-timestamp {{ $msg->user_id === auth()->id() ? 'float-start' : 'float-end' }}">{{ $msg->created_at->format('d M H:i') }}</span>
                    </div>
                    <div class="direct-chat-text">{{ $msg->body }}</div>
                </div>
            @empty
                <p class="text-center text-muted small py-4">Inicie una conversación con directores y administradores de colegios.</p>
            @endforelse
        </div>
    </div>
    @if($conversation)
        <div class="card-footer">
            <form action="{{ route('chat.store', $conversation) }}" method="POST">
                @csrf
                <div class="input-group input-group-sm">
                    <input type="text" name="body" class="form-control" placeholder="Escriba su mensaje..." required>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    @else
        <div class="card-footer text-center">
            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-primary">Abrir mensajería</a>
        </div>
    @endif
</div>
