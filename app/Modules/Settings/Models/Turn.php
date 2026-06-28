<?php

namespace App\Modules\Settings\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turn extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'name',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
