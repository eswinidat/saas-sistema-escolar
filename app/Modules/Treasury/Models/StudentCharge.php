<?php

namespace App\Modules\Treasury\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Settings\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentCharge extends Model
{
    use BelongsToSchool;

    public const STATUSES = [
        'pending' => 'Pendiente',
        'partial' => 'Parcial',
        'paid' => 'Pagado',
        'overdue' => 'Vencido',
        'cancelled' => 'Anulado',
    ];

    protected $fillable = [
        'school_id', 'student_id', 'payment_concept_id', 'academic_year_id',
        'description', 'amount', 'paid_amount', 'due_date', 'status', 'period_label',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentConcept(): BelongsTo
    {
        return $this->belongsTo(PaymentConcept::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function balance(): float
    {
        return max(0, (float) $this->amount - (float) $this->paid_amount);
    }

    public function refreshStatus(): void
    {
        $balance = $this->balance();

        if ($balance <= 0) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } elseif ($this->due_date->isPast()) {
            $this->status = 'overdue';
        } else {
            $this->status = 'pending';
        }

        $this->save();
    }
}
