<?php

namespace App\Modules\Treasury\Models;

use App\Models\User;
use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use BelongsToSchool;

    public const METHODS = [
        'cash' => 'Efectivo',
        'transfer' => 'Transferencia',
        'card' => 'Tarjeta',
        'yape' => 'Yape/Plin',
        'other' => 'Otro',
    ];

    protected $fillable = [
        'school_id', 'student_id', 'student_charge_id', 'amount',
        'payment_date', 'payment_method', 'receipt_number', 'observations', 'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function studentCharge(): BelongsTo
    {
        return $this->belongsTo(StudentCharge::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
