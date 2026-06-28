<?php

namespace App\Modules\Settings\Models;

use App\Models\School;
use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'year',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function activate(): void
    {
        static::withoutGlobalScopes()
            ->where('school_id', $this->school_id)
            ->where('id', '!=', $this->id)
            ->update(['is_active' => false]);

        $this->update(['is_active' => true]);
    }
}
