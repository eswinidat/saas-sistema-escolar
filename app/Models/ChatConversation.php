<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    protected $fillable = ['school_id', 'subject'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class, 'conversation_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latestOfMany();
    }

    public function otherParticipant(int $userId): ?User
    {
        $participant = $this->participants()
            ->where('user_id', '!=', $userId)
            ->with('user')
            ->first();

        return $participant?->user;
    }
}
