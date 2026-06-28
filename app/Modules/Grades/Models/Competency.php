<?php

namespace App\Modules\Grades\Models;

use App\Modules\Academic\Models\Course;
use App\Modules\Core\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competency extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id', 'course_id', 'name', 'code', 'description', 'order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function capabilities(): HasMany
    {
        return $this->hasMany(Capability::class)->orderBy('order');
    }
}
