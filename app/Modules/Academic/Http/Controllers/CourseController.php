<?php

namespace App\Modules\Academic\Http\Controllers;

use App\Modules\Academic\Http\Requests\StoreCourseRequest;
use App\Modules\Academic\Http\Requests\UpdateCourseRequest;
use App\Modules\Academic\Models\Course;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Models\Grade;

class CourseController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Cursos']);
        }

        $courses = Course::with('grade')->orderBy('name')->paginate(15);

        return view('modules.academic.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.academic.courses.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'grades' => Grade::where('is_active', true)->orderBy('order')->pluck('name', 'id'),
        ]);
    }

    public function store(StoreCourseRequest $request)
    {
        Course::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('academic.courses.index')
            ->with('success', 'Curso registrado correctamente.');
    }

    public function edit(Course $course)
    {
        return view('modules.academic.courses.edit', [
            'course' => $course,
            'grades' => Grade::where('is_active', true)->orderBy('order')->pluck('name', 'id'),
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('academic.courses.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('academic.courses.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}
