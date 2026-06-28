<?php

namespace App\Modules\Academic\Models;

use App\Models\User;
use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use BelongsToSchool;

    public const STATUSES = [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        'on_leave' => 'De licencia',
    ];

    protected $fillable = [
        'school_id',
        'user_id',
        'document_type',
        'document_number',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'specialty',
        'hire_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    public function fullName(): string
    {
        return trim("{$this->last_name} {$this->middle_name} {$this->first_name}");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TeacherAssignment::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
