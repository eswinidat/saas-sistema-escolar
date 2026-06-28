<?php

namespace App\Modules\Academic\Http\Controllers;

use App\Modules\Academic\Http\Requests\StoreTeacherAssignmentRequest;
use App\Modules\Academic\Models\Course;
use App\Modules\Academic\Models\Teacher;
use App\Modules\Academic\Models\TeacherAssignment;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;

class TeacherAssignmentController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Asignaciones docentes']);
        }

        $assignments = TeacherAssignment::with(['teacher', 'course', 'section.grade', 'academicYear'])
            ->orderByDesc('id')
            ->paginate(15);

        return view('modules.academic.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.academic.assignments.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'teachers' => Teacher::where('status', 'active')->orderBy('last_name')->get(),
            'courses' => Course::where('is_active', true)->orderBy('name')->get(),
            'sections' => Section::with(['grade', 'academicYear'])->where('is_active', true)->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
        ]);
    }

    public function store(StoreTeacherAssignmentRequest $request)
    {
        TeacherAssignment::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('academic.assignments.index')
            ->with('success', 'Asignación registrada correctamente.');
    }

    public function destroy(TeacherAssignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('academic.assignments.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}
