<?php

namespace App\Modules\Academic\Http\Controllers;

use App\Modules\Academic\Http\Requests\StoreScheduleRequest;
use App\Modules\Academic\Models\Course;
use App\Modules\Academic\Models\Schedule;
use App\Modules\Academic\Models\Teacher;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Section;

class ScheduleController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Horarios']);
        }

        $sectionId = request('section_id');

        $schedules = Schedule::with(['section.grade', 'course', 'teacher', 'academicYear'])
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId))
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate(20);

        $sections = Section::with('grade')->where('is_active', true)->get();

        return view('modules.academic.schedules.index', compact('schedules', 'sections', 'sectionId'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.academic.schedules.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'sections' => Section::with(['grade', 'academicYear'])->where('is_active', true)->get(),
            'courses' => Course::where('is_active', true)->orderBy('name')->get(),
            'teachers' => Teacher::where('status', 'active')->orderBy('last_name')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'days' => Schedule::DAYS,
        ]);
    }

    public function store(StoreScheduleRequest $request)
    {
        Schedule::create($request->validated());

        return redirect()->route('academic.schedules.index')
            ->with('success', 'Horario registrado correctamente.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('academic.schedules.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}
