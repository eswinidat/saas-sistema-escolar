<?php

namespace App\Modules\Grades\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Grades\Models\GradingPeriod;
use App\Modules\Grades\Services\ReportCardPdfService;
use Illuminate\Http\Request;

class ReportCardController extends ModuleController
{
    public function __construct(protected ReportCardPdfService $pdfService) {}

    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Libretas de notas']);
        }

        $students = Student::orderBy('last_name')->get();
        $periods = GradingPeriod::with('academicYear')->orderByDesc('id')->get();
        $studentId = request('student_id');
        $periodId = request('grading_period_id');

        return view('modules.grades.libreta.index', compact('students', 'periods', 'studentId', 'periodId'));
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'grading_period_id' => ['required', 'exists:grading_periods,id'],
        ]);

        $student = Student::findOrFail($request->student_id);
        $period = GradingPeriod::findOrFail($request->grading_period_id);

        return $this->pdfService->download($student, $period);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'grading_period_id' => ['required', 'exists:grading_periods,id'],
        ]);

        $student = Student::findOrFail($request->student_id);
        $period = GradingPeriod::findOrFail($request->grading_period_id);

        return $this->pdfService->stream($student, $period);
    }
}
