<?php

namespace App\Modules\Enrollment\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use BelongsToSchool, SoftDeletes;

    public const STATUSES = [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        'transferred' => 'Trasladado',
        'withdrawn' => 'Retirado',
    ];

    protected $fillable = [
        'school_id',
        'document_type',
        'document_number',
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'gender',
        'blood_type',
        'address',
        'district',
        'province',
        'department',
        'phone',
        'email',
        'photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function fullName(): string
    {
        return trim("{$this->last_name} {$this->middle_name} {$this->first_name}");
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'student_guardian')
            ->withPivot(['relationship', 'is_primary', 'is_economic_responsible'])
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function activeEnrollment(): ?Enrollment
    {
        return $this->enrollments()
            ->where('status', 'active')
            ->latest('enrollment_date')
            ->first();
    }
}
