<?php

namespace App\Modules\Grades\Http\Controllers;

use App\Modules\Academic\Models\Course;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Grades\Models\Capability;
use App\Modules\Grades\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Competencias']);
        }

        $competencies = Competency::with(['course', 'capabilities'])->orderBy('order')->paginate(15);

        return view('modules.grades.competencies.index', compact('competencies'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.grades.competencies.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'courses' => Course::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:200'],
            'code' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'capabilities' => ['nullable', 'array'],
            'capabilities.*' => ['string', 'max:200'],
        ]);

        $competency = Competency::create([
            ...collect($data)->except('capabilities')->all(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        foreach ($request->input('capabilities', []) as $i => $capName) {
            if (trim($capName)) {
                Capability::create([
                    'competency_id' => $competency->id,
                    'name' => trim($capName),
                    'order' => $i + 1,
                ]);
            }
        }

        return redirect()->route('grades.competencies.index')->with('success', 'Competencia registrada.');
    }

    public function destroy(Competency $competency)
    {
        $competency->delete();

        return redirect()->route('grades.competencies.index')->with('success', 'Competencia eliminada.');
    }
}
