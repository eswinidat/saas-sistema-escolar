<?php

namespace App\Modules\Grades\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Settings\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradingPeriod extends Model
{
    use BelongsToSchool;

    public const TYPES = [
        'bimester' => 'Bimestre',
        'trimester' => 'Trimestre',
        'annual' => 'Anual',
    ];

    protected $fillable = [
        'school_id', 'academic_year_id', 'name', 'number', 'type',
        'start_date', 'end_date', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }
}
