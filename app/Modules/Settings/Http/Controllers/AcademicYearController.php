<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Http\Requests\StoreAcademicYearRequest;
use App\Modules\Settings\Http\Requests\UpdateAcademicYearRequest;
use App\Modules\Settings\Models\AcademicYear;

class AcademicYearController extends ModuleController
{
    public function index()
    {
        $schoolId = $this->currentSchoolId();

        if (! $schoolId) {
            return view('modules.settings.no-school', [
                'title' => 'Años Académicos',
            ]);
        }

        $academicYears = AcademicYear::with('school')
            ->orderByDesc('year')
            ->paginate(15);

        return view('modules.settings.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        $schoolId = $this->requireSchoolId();

        return view('modules.settings.academic-years.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $schoolId,
        ]);
    }

    public function store(StoreAcademicYearRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $academicYear = AcademicYear::create($data);

        if ($academicYear->is_active) {
            $academicYear->activate();
        }

        return redirect()
            ->route('settings.academic-years.index')
            ->with('success', 'Año académico registrado correctamente.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('modules.settings.academic-years.edit', compact('academicYear'));
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $academicYear->update($data);

        if ($academicYear->is_active) {
            $academicYear->activate();
        }

        return redirect()
            ->route('settings.academic-years.index')
            ->with('success', 'Año académico actualizado correctamente.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()
            ->route('settings.academic-years.index')
            ->with('success', 'Año académico eliminado correctamente.');
    }
}
