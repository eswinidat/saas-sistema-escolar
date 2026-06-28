<?php

namespace App\Modules\Treasury\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentConcept extends Model
{
    use BelongsToSchool;

    public const TYPES = [
        'enrollment' => 'Matrícula',
        'pension' => 'Pensión',
        'apafa' => 'APAFA',
        'workshop' => 'Taller',
        'uniform' => 'Uniforme',
        'other' => 'Otro',
    ];

    protected $fillable = [
        'school_id', 'name', 'code', 'type', 'default_amount', 'is_recurring', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'default_amount' => 'decimal:2',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function charges(): HasMany
    {
        return $this->hasMany(StudentCharge::class);
    }
}
