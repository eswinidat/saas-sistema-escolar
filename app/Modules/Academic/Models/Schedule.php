<?php

namespace App\Modules\Academic\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use BelongsToSchool;

    public const DAYS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    protected $fillable = [
        'school_id',
        'section_id',
        'course_id',
        'teacher_id',
        'academic_year_id',
        'day_of_week',
        'start_time',
        'end_time',
        'classroom',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
