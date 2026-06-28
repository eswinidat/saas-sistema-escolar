<?php

namespace App\Modules\Billing\Models;

use App\Models\User;
use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Treasury\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SunatSetting extends Model
{
    use BelongsToSchool;

    public const PROVIDERS = [
        'demo' => 'Modo demo (pruebas)',
        'nubefact' => 'Nubefact',
        'factiliza' => 'Factiliza',
        'efact' => 'Efact',
    ];

    protected $fillable = [
        'school_id', 'business_name', 'ruc', 'commercial_name', 'address', 'ubigeo',
        'boleta_series', 'factura_series', 'nota_credito_series',
        'ose_provider', 'ose_api_url', 'ose_api_token',
        'is_production', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_production' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
