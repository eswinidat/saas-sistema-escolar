<?php

namespace App\Modules\Enrollment\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guardian extends Model
{
    use BelongsToSchool;

    public const RELATIONSHIPS = [
        'padre' => 'Padre',
        'madre' => 'Madre',
        'apoderado' => 'Apoderado',
        'tutor' => 'Tutor',
        'otro' => 'Otro',
    ];

    protected $fillable = [
        'school_id',
        'user_id',
        'document_type',
        'document_number',
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'email',
        'address',
        'occupation',
        'is_economic_responsible',
    ];

    protected function casts(): array
    {
        return [
            'is_economic_responsible' => 'boolean',
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

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_guardian')
            ->withPivot(['relationship', 'is_primary', 'is_economic_responsible'])
            ->withTimestamps();
    }
}
