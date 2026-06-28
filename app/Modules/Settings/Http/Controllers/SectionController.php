<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Http\Requests\StoreSectionRequest;
use App\Modules\Settings\Http\Requests\UpdateSectionRequest;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Grade;
use App\Modules\Settings\Models\Section;
use App\Modules\Settings\Models\Turn;

class SectionController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Secciones']);
        }

        $sections = Section::with(['grade.level', 'academicYear', 'turn'])
            ->orderBy('name')
            ->paginate(15);

        return view('modules.settings.sections.index', compact('sections'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.settings.sections.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
            'grades' => Grade::with('level')->where('is_active', true)->orderBy('order')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'turns' => Turn::where('is_active', true)->pluck('name', 'id'),
        ]);
    }

    public function store(StoreSectionRequest $request)
    {
        Section::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('settings.sections.index')
            ->with('success', 'Sección registrada correctamente.');
    }

    public function edit(Section $section)
    {
        return view('modules.settings.sections.edit', [
            'section' => $section,
            'grades' => Grade::with('level')->where('is_active', true)->orderBy('order')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
            'turns' => Turn::where('is_active', true)->pluck('name', 'id'),
        ]);
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('settings.sections.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()
            ->route('settings.sections.index')
            ->with('success', 'Sección eliminada correctamente.');
    }
}
