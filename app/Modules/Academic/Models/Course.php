<?php

namespace App\Modules\Academic\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Settings\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'grade_id',
        'name',
        'code',
        'description',
        'hours_per_week',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
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
