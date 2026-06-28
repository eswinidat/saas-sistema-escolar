<?php

namespace App\Modules\Academic\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherAssignment extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'teacher_id',
        'course_id',
        'section_id',
        'academic_year_id',
        'hours_per_week',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
