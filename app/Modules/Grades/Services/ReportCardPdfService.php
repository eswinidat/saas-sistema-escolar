<?php

namespace App\Modules\Grades\Services;

use App\Models\School;
use App\Modules\Attendance\Models\AttendanceRecord;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Grades\Models\GradingPeriod;
use App\Modules\Grades\Models\StudentGrade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ReportCardPdfService
{
    public function download(Student $student, GradingPeriod $period)
    {
        $data = $this->buildData($student, $period);

        $pdf = Pdf::loadView('modules.grades.pdf.libreta', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'libreta-'.$student->document_number.'-'.$period->name.'.pdf';

        return $pdf->download($filename);
    }

    public function stream(Student $student, GradingPeriod $period)
    {
        $data = $this->buildData($student, $period);

        return Pdf::loadView('modules.grades.pdf.libreta', $data)
            ->setPaper('a4', 'portrait')
            ->stream('libreta.pdf');
    }

    public function buildData(Student $student, GradingPeriod $period): array
    {
        $period->loadMissing('academicYear');
        $school = School::find($student->school_id);
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('academic_year_id', $period->academic_year_id)
            ->where('status', 'active')
            ->with(['section.grade.level', 'section.turn'])
            ->first();

        $grades = StudentGrade::with(['course', 'competency', 'capability'])
            ->where('student_id', $student->id)
            ->where('grading_period_id', $period->id)
            ->get()
            ->groupBy(fn ($g) => $g->course->name ?? 'General');

        $attendance = $this->attendanceSummary($student, $period);

        return compact('student', 'period', 'school', 'enrollment', 'grades', 'attendance');
    }

    protected function attendanceSummary(Student $student, GradingPeriod $period): Collection
    {
        $query = AttendanceRecord::where('student_id', $student->id);

        if ($period->start_date && $period->end_date) {
            $query->whereBetween('date', [$period->start_date, $period->end_date]);
        }

        $records = $query->get();

        return collect([
            'present' => $records->where('status', 'present')->count(),
            'absent' => $records->where('status', 'absent')->count(),
            'late' => $records->where('status', 'late')->count(),
            'justified' => $records->whereIn('status', ['justified', 'excused'])->count(),
            'total' => $records->count(),
        ]);
    }
}
