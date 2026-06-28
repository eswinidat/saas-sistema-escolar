<?php

namespace App\Modules\Settings\Models;

use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'order',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class)->orderBy('order');
    }
}
