<?php

namespace App\Modules\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SchoolScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! app()->bound('current_school_id')) {
            return;
        }

        $schoolId = app('current_school_id');

        if ($schoolId) {
            $builder->where($model->getTable().'.school_id', $schoolId);
        }
    }
}
