<?php

namespace App\Modules\Attendance\Models;

use App\Models\User;
use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use BelongsToSchool;

    public const STATUSES = [
        'present' => 'Presente',
        'absent' => 'Falta',
        'late' => 'Tardanza',
        'justified' => 'Justificada',
        'excused' => 'Permiso',
    ];

    protected $fillable = [
        'school_id',
        'student_id',
        'section_id',
        'academic_year_id',
        'date',
        'status',
        'check_in_time',
        'check_out_time',
        'tardiness_minutes',
        'justification',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
