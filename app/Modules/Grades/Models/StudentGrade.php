<?php

namespace App\Modules\Grades\Models;

use App\Models\User;
use App\Modules\Academic\Models\Course;
use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    use BelongsToSchool;

    public const ACHIEVEMENT_LEVELS = [
        'AD' => 'Logro destacado',
        'A' => 'Logro esperado',
        'B' => 'En proceso',
        'C' => 'En inicio',
    ];

    protected $fillable = [
        'school_id', 'student_id', 'course_id', 'grading_period_id',
        'competency_id', 'capability_id', 'achievement_level',
        'numeric_grade', 'observations', 'recorded_by',
    ];

    protected function casts(): array
    {
        return ['numeric_grade' => 'decimal:2'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function gradingPeriod(): BelongsTo
    {
        return $this->belongsTo(GradingPeriod::class);
    }

    public function competency(): BelongsTo
    {
        return $this->belongsTo(Competency::class);
    }

    public function capability(): BelongsTo
    {
        return $this->belongsTo(Capability::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
