<?php

namespace App\Modules\Settings\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'grade_id',
        'academic_year_id',
        'turn_id',
        'name',
        'capacity',
        'tutor_name',
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

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function turn(): BelongsTo
    {
        return $this->belongsTo(Turn::class);
    }

    public function fullName(): string
    {
        return "{$this->grade->name} - {$this->name}";
    }
}
