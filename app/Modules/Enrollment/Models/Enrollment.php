<?php

namespace App\Modules\Enrollment\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use App\Modules\Settings\Models\Turn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use BelongsToSchool;

    public const TYPES = [
        'new' => 'Matrícula nueva',
        'ratification' => 'Ratificación',
        'reservation' => 'Reserva',
        'transfer' => 'Traslado',
    ];

    public const STATUSES = [
        'active' => 'Activo',
        'withdrawn' => 'Retirado',
        'transferred' => 'Trasladado',
        'completed' => 'Completado',
    ];

    protected $fillable = [
        'school_id',
        'student_id',
        'academic_year_id',
        'section_id',
        'turn_id',
        'enrollment_number',
        'enrollment_date',
        'type',
        'status',
        'observations',
    ];

    protected function casts(): array
    {
        return [
            'enrollment_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function turn(): BelongsTo
    {
        return $this->belongsTo(Turn::class);
    }
}
