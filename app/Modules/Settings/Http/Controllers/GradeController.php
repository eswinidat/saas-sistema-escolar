<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Http\Requests\StoreGradeRequest;
use App\Modules\Settings\Http\Requests\UpdateGradeRequest;
use App\Modules\Settings\Models\Grade;
use App\Modules\Settings\Models\Level;

class GradeController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Grados']);
        }

        $grades = Grade::with('level')->orderBy('order')->paginate(15);

        return view('modules.settings.grades.index', compact('grades'));
    }

    public function create()
    {
        $this->requireSchoolId();

        $levels = Level::where('is_active', true)->orderBy('order')->pluck('name', 'id');

        return view('modules.settings.grades.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
            'levels' => $levels,
        ]);
    }

    public function store(StoreGradeRequest $request)
    {
        Grade::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('settings.grades.index')
            ->with('success', 'Grado registrado correctamente.');
    }

    public function edit(Grade $grade)
    {
        $levels = Level::where('is_active', true)->orderBy('order')->pluck('name', 'id');

        return view('modules.settings.grades.edit', compact('grade', 'levels'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('settings.grades.index')
            ->with('success', 'Grado actualizado correctamente.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()
            ->route('settings.grades.index')
            ->with('success', 'Grado eliminado correctamente.');
    }
}
