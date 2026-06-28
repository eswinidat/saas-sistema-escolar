<?php

namespace App\Modules\Academic\Http\Controllers;

use App\Modules\Academic\Http\Requests\StoreTeacherRequest;
use App\Modules\Academic\Http\Requests\UpdateTeacherRequest;
use App\Modules\Academic\Models\Teacher;
use App\Modules\Core\Http\Controllers\ModuleController;

class TeacherController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Docentes']);
        }

        $teachers = Teacher::orderBy('last_name')->paginate(15);

        return view('modules.academic.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.academic.teachers.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'statuses' => Teacher::STATUSES,
        ]);
    }

    public function store(StoreTeacherRequest $request)
    {
        Teacher::create($request->validated());

        return redirect()->route('academic.teachers.index')
            ->with('success', 'Docente registrado correctamente.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['assignments.course', 'assignments.section.grade', 'assignments.academicYear']);

        return view('modules.academic.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('modules.academic.teachers.edit', [
            'teacher' => $teacher,
            'statuses' => Teacher::STATUSES,
        ]);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());

        return redirect()->route('academic.teachers.show', $teacher)
            ->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('academic.teachers.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}
