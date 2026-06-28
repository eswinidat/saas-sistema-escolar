<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\User;
use App\Services\ChatService;
use App\Support\AdminPanel;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chat) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $conversations = $this->chat->conversationsFor($user);

        $contacts = collect();
        if ($user->hasRole('Super Administrador')) {
            $contacts = $this->chat->schoolContactsForSuperAdmin();
        } elseif ($user->hasRole(['Administrador Colegio', 'Secretaria'])) {
            $super = $this->chat->superAdminContact();
            if ($super) {
                $contacts = collect([$super]);
            }
        }

        return view('chat.index', compact('conversations', 'contacts'));
    }

    public function show(Request $request, ChatConversation $conversation)
    {
        abort_unless($this->canAccess($request->user(), $conversation), 403);

        $this->chat->markRead($conversation, $request->user());

        $conversation->load(['messages.user', 'participants.user', 'school']);

        return view('chat.show', [
            'conversation' => $conversation,
            'other' => $conversation->otherParticipant($request->user()->id),
        ]);
    }

    public function start(Request $request, User $contact)
    {
        abort_unless($this->canContact($request->user(), $contact), 403);

        $conversation = $this->chat->findOrCreateDirect($request->user(), $contact);

        return redirect()->route('chat.show', $conversation);
    }

    public function store(Request $request, ChatConversation $conversation)
    {
        abort_unless($this->canAccess($request->user(), $conversation), 403);

        $data = $request->validate(['body' => ['required', 'string', 'max:2000']]);

        $this->chat->send($conversation, $request->user(), $data['body']);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    protected function canAccess(User $user, ChatConversation $conversation): bool
    {
        return $conversation->participants()->where('user_id', $user->id)->exists();
    }

    protected function canContact(User $user, User $contact): bool
    {
        if ($user->hasRole('Super Administrador')) {
            return $contact->hasRole(['Administrador Colegio', 'Secretaria']);
        }

        if ($user->hasRole(['Administrador Colegio', 'Secretaria'])) {
            return $contact->hasRole('Super Administrador');
        }

        return false;
    }
}
