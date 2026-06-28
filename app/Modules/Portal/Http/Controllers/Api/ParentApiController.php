<?php

namespace App\Modules\Portal\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Attendance\Models\AttendanceRecord;
use App\Modules\Grades\Models\StudentGrade;
use App\Modules\Portal\Services\ParentPortalService;
use App\Modules\Treasury\Models\StudentCharge;
use Illuminate\Http\Request;

class ParentApiController extends Controller
{
    public function __construct(protected ParentPortalService $portal) {}

    public function students(Request $request)
    {
        return response()->json([
            'data' => $this->portal->studentsForUser($request->user())->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->fullName(),
                'document' => $s->document_number,
                'enrollment' => optional($s->activeEnrollment()?->section)->fullName(),
            ]),
        ]);
    }

    public function grades(Request $request, int $studentId)
    {
        $student = $this->portal->selectedStudent($request->user(), $studentId);
        abort_unless($student, 404);

        $grades = StudentGrade::with(['course', 'competency', 'gradingPeriod'])
            ->where('student_id', $student->id)
            ->get()
            ->map(fn ($g) => [
                'period' => $g->gradingPeriod->name,
                'course' => $g->course->name,
                'competency' => $g->competency->name,
                'achievement_level' => $g->achievement_level,
                'numeric_grade' => $g->numeric_grade,
            ]);

        return response()->json(['data' => $grades]);
    }

    public function attendance(Request $request, int $studentId)
    {
        $student = $this->portal->selectedStudent($request->user(), $studentId);
        abort_unless($student, 404);

        $records = AttendanceRecord::where('student_id', $student->id)
            ->orderByDesc('date')->limit(90)->get()
            ->map(fn ($r) => [
                'date' => $r->date->toDateString(),
                'status' => $r->status,
                'tardiness_minutes' => $r->tardiness_minutes,
            ]);

        return response()->json(['data' => $records]);
    }

    public function payments(Request $request, int $studentId)
    {
        $student = $this->portal->selectedStudent($request->user(), $studentId);
        abort_unless($student, 404);

        $charges = StudentCharge::with('paymentConcept')
            ->where('student_id', $student->id)->get()
            ->map(fn ($c) => [
                'concept' => $c->paymentConcept->name,
                'amount' => (float) $c->amount,
                'paid_amount' => (float) $c->paid_amount,
                'balance' => $c->balance(),
                'due_date' => $c->due_date->toDateString(),
                'status' => $c->status,
            ]);

        return response()->json(['data' => $charges]);
    }
}
