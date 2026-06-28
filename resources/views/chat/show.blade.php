@extends('layouts.admin')

@section('content')
<div class="content-header mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h1 class="m-0">Chat con {{ $other?->name ?? 'Soporte' }}</h1>
            @if($conversation->school)<small class="text-muted">{{ $conversation->school->name }}</small>@endif
        </div>
        <div class="col-sm-6 text-end"><a href="{{ route('chat.index') }}" class="btn btn-outline-secondary btn-sm">← Volver</a></div>
    </div>
</div>

<div class="card direct-chat direct-chat-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $other?->name ?? 'Conversación' }}</h3>
        <div class="card-tools">
            <span class="badge text-bg-primary">{{ $conversation->messages->count() }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="direct-chat-messages" style="height:400px;overflow-y:auto;">
            @foreach($conversation->messages as $msg)
                <div class="direct-chat-msg {{ $msg->user_id === auth()->id() ? 'end' : '' }}">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name {{ $msg->user_id === auth()->id() ? 'float-end' : 'float-start' }}">{{ $msg->user->name }}</span>
                        <span class="direct-chat-timestamp {{ $msg->user_id === auth()->id() ? 'float-start' : 'float-end' }}">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="direct-chat-text">{{ $msg->body }}</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        <form action="{{ route('chat.store', $conversation) }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="body" placeholder="Escriba su mensaje..." class="form-control" required maxlength="2000" autofocus>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const box = document.querySelector('.direct-chat-messages');
    if (box) box.scrollTop = box.scrollHeight;
});
</script>
@endpush
