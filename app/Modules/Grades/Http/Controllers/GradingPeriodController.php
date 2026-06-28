<?php

namespace App\Modules\Grades\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Grades\Models\GradingPeriod;
use App\Modules\Settings\Models\AcademicYear;
use Illuminate\Http\Request;

class GradingPeriodController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Periodos de evaluación']);
        }

        $periods = GradingPeriod::with('academicYear')->orderByDesc('id')->paginate(15);

        return view('modules.grades.periods.index', compact('periods'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.grades.periods.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'types' => GradingPeriod::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name' => ['required', 'string', 'max:100'],
            'number' => ['required', 'integer', 'min:1', 'max:12'],
            'type' => ['required', 'in:bimester,trimester,annual'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        GradingPeriod::create($data);

        return redirect()->route('grades.periods.index')->with('success', 'Periodo registrado.');
    }

    public function destroy(GradingPeriod $period)
    {
        $period->delete();

        return redirect()->route('grades.periods.index')->with('success', 'Periodo eliminado.');
    }
}
