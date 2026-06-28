<?php

namespace App\Modules\Grades\Http\Controllers;

use App\Modules\Academic\Models\Course;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Grades\Models\Competency;
use App\Modules\Grades\Models\GradingPeriod;
use App\Modules\Grades\Models\StudentGrade;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;
use Illuminate\Http\Request;

class GradeEntryController extends ModuleController
{
    public function create()
    {
        $this->requireSchoolId();

        $sectionId = request('section_id');
        $courseId = request('course_id');
        $periodId = request('grading_period_id');
        $academicYearId = request('academic_year_id', AcademicYear::where('is_active', true)->value('id'));

        $students = collect();
        $existing = collect();
        $competency = null;

        if ($sectionId && $courseId && $periodId && $academicYearId) {
            $studentIds = Enrollment::where('section_id', $sectionId)
                ->where('academic_year_id', $academicYearId)
                ->where('status', 'active')
                ->pluck('student_id');

            $students = Student::whereIn('id', $studentIds)->orderBy('last_name')->get();
            $competency = Competency::with('capabilities')
                ->where('course_id', $courseId)
                ->where('is_active', true)
                ->first();

            $existing = StudentGrade::where('course_id', $courseId)
                ->where('grading_period_id', $periodId)
                ->when($competency, fn ($q) => $q->where('competency_id', $competency->id))
                ->get()
                ->keyBy('student_id');
        }

        return view('modules.grades.entry.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'sections' => Section::with(['grade', 'academicYear'])->where('is_active', true)->get(),
            'courses' => Course::where('is_active', true)->orderBy('name')->get(),
            'periods' => GradingPeriod::orderBy('number')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'sectionId' => $sectionId,
            'courseId' => $courseId,
            'periodId' => $periodId,
            'academicYearId' => $academicYearId,
            'students' => $students,
            'competency' => $competency,
            'existing' => $existing,
            'levels' => StudentGrade::ACHIEVEMENT_LEVELS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'grading_period_id' => ['required', 'exists:grading_periods,id'],
            'competency_id' => ['required', 'exists:competencies,id'],
            'records' => ['required', 'array'],
            'records.*.student_id' => ['required', 'exists:students,id'],
            'records.*.achievement_level' => ['nullable', 'in:AD,A,B,C'],
            'records.*.numeric_grade' => ['nullable', 'numeric', 'min:0', 'max:20'],
            'records.*.observations' => ['nullable', 'string'],
        ]);

        foreach ($data['records'] as $record) {
            if (empty($record['achievement_level']) && empty($record['numeric_grade'])) {
                continue;
            }

            StudentGrade::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'course_id' => $data['course_id'],
                    'grading_period_id' => $data['grading_period_id'],
                    'competency_id' => $data['competency_id'],
                    'capability_id' => null,
                ],
                [
                    'school_id' => $data['school_id'],
                    'achievement_level' => $record['achievement_level'] ?? null,
                    'numeric_grade' => $record['numeric_grade'] ?? null,
                    'observations' => $record['observations'] ?? null,
                    'recorded_by' => $request->user()->id,
                ]
            );
        }

        return redirect()->route('grades.entry.create', [
            'section_id' => $data['section_id'],
            'course_id' => $data['course_id'],
            'grading_period_id' => $data['grading_period_id'],
        ])->with('success', 'Calificaciones guardadas.');
    }

    public function report()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Boleta de notas']);
        }

        $studentId = request('student_id');
        $periodId = request('grading_period_id');

        $grades = StudentGrade::with(['student', 'course', 'competency', 'gradingPeriod'])
            ->when($studentId, fn ($q) => $q->where('student_id', $studentId))
            ->when($periodId, fn ($q) => $q->where('grading_period_id', $periodId))
            ->orderBy('student_id')
            ->paginate(30);

        $students = Student::orderBy('last_name')->get();
        $periods = GradingPeriod::orderBy('number')->get();

        return view('modules.grades.report.index', compact('grades', 'students', 'periods', 'studentId', 'periodId'));
    }
}
