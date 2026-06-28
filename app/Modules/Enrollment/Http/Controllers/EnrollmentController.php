<?php

namespace App\Modules\Enrollment\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Http\Requests\StoreEnrollmentRequest;
use App\Modules\Enrollment\Http\Requests\UpdateEnrollmentRequest;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use App\Modules\Settings\Models\Turn;

class EnrollmentController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Matrículas']);
        }

        $enrollments = Enrollment::with(['student', 'section.grade', 'academicYear', 'turn'])
            ->orderByDesc('enrollment_date')
            ->paginate(15);

        return view('modules.enrollment.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.enrollment.enrollments.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
            'students' => Student::where('status', 'active')->orderBy('last_name')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'sections' => Section::with(['grade.level', 'academicYear'])->where('is_active', true)->get(),
            'turns' => Turn::where('is_active', true)->pluck('name', 'id'),
            'types' => Enrollment::TYPES,
            'statuses' => Enrollment::STATUSES,
        ]);
    }

    public function store(StoreEnrollmentRequest $request)
    {
        Enrollment::create($request->validated());

        return redirect()
            ->route('enrollment.enrollments.index')
            ->with('success', 'Matrícula registrada correctamente.');
    }

    public function edit(Enrollment $enrollment)
    {
        return view('modules.enrollment.enrollments.edit', [
            'enrollment' => $enrollment->load(['student', 'section.grade']),
            'sections' => Section::with(['grade.level', 'academicYear'])->where('is_active', true)->get(),
            'turns' => Turn::where('is_active', true)->pluck('name', 'id'),
            'types' => Enrollment::TYPES,
            'statuses' => Enrollment::STATUSES,
        ]);
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());

        return redirect()
            ->route('enrollment.enrollments.index')
            ->with('success', 'Matrícula actualizada correctamente.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollment.enrollments.index')
            ->with('success', 'Matrícula eliminada correctamente.');
    }
}
