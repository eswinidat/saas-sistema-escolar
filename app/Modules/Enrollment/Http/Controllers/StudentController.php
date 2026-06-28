<?php

namespace App\Modules\Enrollment\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Http\Requests\StoreStudentRequest;
use App\Modules\Enrollment\Http\Requests\UpdateStudentRequest;
use App\Modules\Enrollment\Models\Student;

class StudentController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Alumnos']);
        }

        $students = Student::orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15);

        return view('modules.enrollment.students.index', compact('students'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.enrollment.students.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
            'statuses' => Student::STATUSES,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());

        return redirect()
            ->route('enrollment.students.index')
            ->with('success', 'Alumno registrado correctamente.');
    }

    public function show(Student $student)
    {
        $student->load(['guardians', 'enrollments.section.grade', 'enrollments.academicYear']);

        return view('modules.enrollment.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('modules.enrollment.students.edit', [
            'student' => $student,
            'statuses' => Student::STATUSES,
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()
            ->route('enrollment.students.show', $student)
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('enrollment.students.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}
