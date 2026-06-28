<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;

abstract class ModuleController extends Controller
{
    protected function currentSchoolId(): ?int
    {
        return app()->bound('current_school_id') ? app('current_school_id') : null;
    }

    protected function schoolsForSelect(): array
    {
        return School::where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    protected function requireSchoolId(): int
    {
        $schoolId = $this->currentSchoolId();

        abort_unless($schoolId, 403, 'Debe seleccionar un colegio para continuar.');

        return $schoolId;
    }
}
