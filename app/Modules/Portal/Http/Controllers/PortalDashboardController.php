<?php

namespace App\Modules\Portal\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Attendance\Models\AttendanceRecord;
use App\Modules\Grades\Models\GradingPeriod;
use App\Modules\Grades\Models\StudentGrade;
use App\Modules\Grades\Services\ReportCardPdfService;
use App\Modules\Portal\Services\ParentPortalService;
use App\Modules\Treasury\Models\StudentCharge;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PortalDashboardController extends Controller
{
    public function __construct(
        protected ParentPortalService $portal,
        protected ReportCardPdfService $reportCardPdf,
    ) {}

    public function index(Request $request)
    {
        $student = $this->portal->selectedStudent($request->user(), $request->integer('student_id') ?: null);
        $students = $this->portal->studentsForUser($request->user());

        $stats = ['grades' => 0, 'attendance_present' => 0, 'pending_charges' => 0, 'balance' => 0];

        if ($student) {
            $stats['grades'] = StudentGrade::where('student_id', $student->id)->count();
            $stats['attendance_present'] = AttendanceRecord::where('student_id', $student->id)
                ->where('status', 'present')->count();
            $charges = StudentCharge::where('student_id', $student->id)
                ->whereIn('status', ['pending', 'partial', 'overdue'])->get();
            $stats['pending_charges'] = $charges->count();
            $stats['balance'] = $charges->sum(fn ($c) => $c->balance());
        }

        return Inertia::render('Portal/Dashboard', [
            ...$this->portalContext($request, $student, $students),
            'stats' => $stats,
        ]);
    }

    protected function portalContext(Request $request, $student, $students): array
    {
        $school = $request->user()->school;

        $hour = (int) now()->format('H');
        $greeting = $hour < 12 ? 'Buenos días' : ($hour < 18 ? 'Buenas tardes' : 'Buenas noches');

        return [
            'students' => $students->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->fullName(),
                'section' => optional($s->activeEnrollment()?->section)->fullName(),
            ]),
            'selectedStudentId' => $student?->id,
            'selectedStudent' => $student ? [
                'name' => $student->fullName(),
                'section' => optional($student->activeEnrollment()?->section)->fullName(),
            ] : null,
            'school' => $school ? ['name' => $school->name, 'ruc' => $school->ruc] : null,
            'greeting' => $greeting.', '.$request->user()->name,
        ];
    }

    public function grades(Request $request)
    {
        $students = $this->portal->studentsForUser($request->user());
        $student = $this->portal->selectedStudent($request->user(), $request->integer('student_id') ?: null);

        $grades = $student
            ? StudentGrade::with(['course', 'competency', 'gradingPeriod'])
                ->where('student_id', $student->id)
                ->orderByDesc('grading_period_id')
                ->get()
                ->map(fn ($g) => [
                    'period' => $g->gradingPeriod->name ?? '',
                    'course' => $g->course->name ?? '',
                    'competency' => $g->competency->name ?? '',
                    'level' => $g->achievement_level,
                    'level_label' => StudentGrade::ACHIEVEMENT_LEVELS[$g->achievement_level] ?? '',
                    'numeric' => $g->numeric_grade,
                    'observations' => $g->observations,
                ])
            : collect();

        $periods = GradingPeriod::orderByDesc('id')->get()
            ->map(fn ($p) => ['id' => $p->id, 'name' => $p->name]);

        return Inertia::render('Portal/Grades', [
            'students' => $students->map(fn ($s) => ['id' => $s->id, 'name' => $s->fullName()]),
            'selectedStudentId' => $student?->id,
            'grades' => $grades,
            'periods' => $periods,
        ]);
    }

    public function libretaPdf(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'integer'],
            'grading_period_id' => ['required', 'integer', 'exists:grading_periods,id'],
        ]);

        $student = $this->portal->selectedStudent($request->user(), (int) $request->student_id);
        abort_unless($student, 403);

        $period = GradingPeriod::findOrFail($request->grading_period_id);

        return $this->reportCardPdf->download($student, $period);
    }

    public function attendance(Request $request)
    {
        $student = $this->portal->selectedStudent($request->user(), $request->integer('student_id') ?: null);

        $records = $student
            ? AttendanceRecord::where('student_id', $student->id)
                ->orderByDesc('date')->limit(60)->get()
                ->map(fn ($r) => [
                    'date' => $r->date->format('d/m/Y'),
                    'status' => $r->status,
                    'label' => AttendanceRecord::STATUSES[$r->status] ?? $r->status,
                    'check_in' => $r->check_in_time ? substr($r->check_in_time, 0, 5) : null,
                    'tardiness' => $r->tardiness_minutes,
                ])
            : collect();

        return Inertia::render('Portal/Attendance', [
            'students' => $this->portal->studentsForUser($request->user())->map(fn ($s) => [
                'id' => $s->id, 'name' => $s->fullName(),
            ]),
            'selectedStudentId' => $student?->id,
            'records' => $records,
        ]);
    }

    public function payments(Request $request)
    {
        $student = $this->portal->selectedStudent($request->user(), $request->integer('student_id') ?: null);

        $charges = $student
            ? StudentCharge::with('paymentConcept')
                ->where('student_id', $student->id)
                ->orderByDesc('due_date')->get()
                ->map(fn ($c) => [
                    'concept' => $c->paymentConcept->name ?? '',
                    'period' => $c->period_label,
                    'amount' => (float) $c->amount,
                    'paid' => (float) $c->paid_amount,
                    'balance' => $c->balance(),
                    'due_date' => $c->due_date->format('d/m/Y'),
                    'status' => $c->status,
                    'status_label' => StudentCharge::STATUSES[$c->status] ?? $c->status,
                ])
            : collect();

        return Inertia::render('Portal/Payments', [
            'students' => $this->portal->studentsForUser($request->user())->map(fn ($s) => [
                'id' => $s->id, 'name' => $s->fullName(),
            ]),
            'selectedStudentId' => $student?->id,
            'charges' => $charges,
            'totalBalance' => $charges->sum('balance'),
        ]);
    }
}
