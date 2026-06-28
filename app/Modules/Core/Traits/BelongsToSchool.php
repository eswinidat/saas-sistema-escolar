<?php

namespace App\Modules\Core\Traits;

use App\Models\School;
use App\Modules\Core\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSchool
{
    public static function bootBelongsToSchool(): void
    {
        static::addGlobalScope(new SchoolScope);

        static::creating(function ($model) {
            if (! $model->school_id && app()->bound('current_school_id')) {
                $model->school_id = app('current_school_id');
            }
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
