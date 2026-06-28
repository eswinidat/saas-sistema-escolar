<?php

namespace App\Modules\Attendance\Http\Controllers;

use App\Modules\Attendance\Http\Requests\StoreDailyAttendanceRequest;
use App\Modules\Attendance\Http\Requests\UpdateAttendanceRecordRequest;
use App\Modules\Attendance\Models\AttendanceRecord;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;

class AttendanceController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Asistencia']);
        }

        $query = AttendanceRecord::with(['student', 'section.grade'])
            ->orderByDesc('date')
            ->orderBy('student_id');

        if ($sectionId = request('section_id')) {
            $query->where('section_id', $sectionId);
        }

        if ($date = request('date')) {
            $query->whereDate('date', $date);
        }

        $records = $query->paginate(20)->withQueryString();
        $sections = Section::with('grade')->where('is_active', true)->get();

        return view('modules.attendance.index', compact('records', 'sections'));
    }

    public function take()
    {
        $this->requireSchoolId();

        $sections = Section::with(['grade', 'academicYear'])->where('is_active', true)->get();
        $academicYears = AcademicYear::orderByDesc('year')->pluck('year', 'id');
        $activeYear = AcademicYear::where('is_active', true)->first();

        $sectionId = request('section_id');
        $date = request('date', now()->toDateString());
        $academicYearId = request('academic_year_id', $activeYear?->id);

        $students = collect();
        $existingRecords = collect();

        if ($sectionId && $academicYearId) {
            $studentIds = Enrollment::where('section_id', $sectionId)
                ->where('academic_year_id', $academicYearId)
                ->where('status', 'active')
                ->pluck('student_id');

            $students = \App\Modules\Enrollment\Models\Student::whereIn('id', $studentIds)
                ->orderBy('last_name')
                ->get();

            $existingRecords = AttendanceRecord::where('section_id', $sectionId)
                ->whereDate('date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('modules.attendance.take', [
            'sections' => $sections,
            'academicYears' => $academicYears,
            'sectionId' => $sectionId,
            'academicYearId' => $academicYearId,
            'date' => $date,
            'students' => $students,
            'existingRecords' => $existingRecords,
            'statuses' => AttendanceRecord::STATUSES,
            'selectedSchoolId' => $this->currentSchoolId(),
        ]);
    }

    public function store(StoreDailyAttendanceRequest $request)
    {
        $data = $request->validated();
        $userId = $request->user()->id;

        foreach ($data['records'] as $record) {
            AttendanceRecord::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'date' => $data['date'],
                ],
                [
                    'school_id' => $data['school_id'],
                    'section_id' => $data['section_id'],
                    'academic_year_id' => $data['academic_year_id'],
                    'status' => $record['status'],
                    'check_in_time' => $record['check_in_time'] ?? null,
                    'check_out_time' => $record['check_out_time'] ?? null,
                    'tardiness_minutes' => $record['tardiness_minutes'] ?? 0,
                    'justification' => $record['justification'] ?? null,
                    'recorded_by' => $userId,
                ]
            );
        }

        return redirect()->route('attendance.index', [
            'section_id' => $data['section_id'],
            'date' => $data['date'],
        ])->with('success', 'Asistencia registrada correctamente.');
    }

    public function edit(AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->load(['student', 'section.grade']);

        return view('modules.attendance.edit', [
            'record' => $attendanceRecord,
            'statuses' => AttendanceRecord::STATUSES,
        ]);
    }

    public function update(UpdateAttendanceRecordRequest $request, AttendanceRecord $attendanceRecord)
    {
        $attendanceRecord->update([
            ...$request->validated(),
            'recorded_by' => $request->user()->id,
        ]);

        return redirect()->route('attendance.index', [
            'section_id' => $attendanceRecord->section_id,
            'date' => $attendanceRecord->date->format('Y-m-d'),
        ])->with('success', 'Registro de asistencia actualizado.');
    }
}
