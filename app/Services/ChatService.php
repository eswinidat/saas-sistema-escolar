<?php

namespace App\Services;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function findOrCreateDirect(User $a, User $b): ChatConversation
    {
        $existing = ChatConversation::whereHas('participants', fn ($q) => $q->where('user_id', $a->id))
            ->whereHas('participants', fn ($q) => $q->where('user_id', $b->id))
            ->whereDoesntHave('participants', fn ($q) => $q->whereNotIn('user_id', [$a->id, $b->id]))
            ->first();

        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($a, $b) {
            $conversation = ChatConversation::create([
                'school_id' => $b->school_id ?? $a->school_id,
                'subject' => 'Soporte plataforma',
            ]);

            foreach ([$a, $b] as $user) {
                ChatParticipant::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id,
                    'last_read_at' => now(),
                ]);
            }

            return $conversation;
        });
    }

    public function send(ChatConversation $conversation, User $sender, string $body): ChatMessage
    {
        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $sender->id,
            'body' => trim($body),
        ]);

        ChatParticipant::where('conversation_id', $conversation->id)
            ->where('user_id', $sender->id)
            ->update(['last_read_at' => now()]);

        return $message->load('user');
    }

    public function conversationsFor(User $user): Collection
    {
        return ChatConversation::whereHas('participants', fn ($q) => $q->where('user_id', $user->id))
            ->with(['latestMessage.user', 'school', 'participants.user'])
            ->orderByDesc(
                ChatMessage::select('created_at')
                    ->whereColumn('conversation_id', 'chat_conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->get();
    }

    public function unreadCount(User $user): int
    {
        return ChatParticipant::where('user_id', $user->id)
            ->with('conversation.messages')
            ->get()
            ->sum(function ($participant) {
                $lastRead = $participant->last_read_at;

                return $participant->conversation->messages
                    ->where('user_id', '!=', $participant->user_id)
                    ->when($lastRead, fn ($c) => $c->where('created_at', '>', $lastRead))
                    ->count();
            });
    }

    public function markRead(ChatConversation $conversation, User $user): void
    {
        ChatParticipant::where('conversation_id', $conversation->id)
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
    }

    public function schoolContactsForSuperAdmin(): Collection
    {
        return User::role(['Administrador Colegio', 'Secretaria'])
            ->with('school')
            ->orderBy('name')
            ->get();
    }

    public function superAdminContact(): ?User
    {
        return User::role('Super Administrador')->first();
    }
}
