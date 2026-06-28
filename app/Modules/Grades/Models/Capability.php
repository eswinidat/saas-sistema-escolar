<?php

namespace App\Modules\Grades\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capability extends Model
{
    protected $fillable = ['competency_id', 'name', 'code', 'order'];

    public function competency(): BelongsTo
    {
        return $this->belongsTo(Competency::class);
    }

    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }
}
