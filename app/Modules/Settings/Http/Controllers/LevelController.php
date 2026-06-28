<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Http\Requests\StoreLevelRequest;
use App\Modules\Settings\Http\Requests\UpdateLevelRequest;
use App\Modules\Settings\Models\Level;

class LevelController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Niveles']);
        }

        $levels = Level::orderBy('order')->paginate(15);

        return view('modules.settings.levels.index', compact('levels'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.settings.levels.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
        ]);
    }

    public function store(StoreLevelRequest $request)
    {
        Level::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('settings.levels.index')
            ->with('success', 'Nivel registrado correctamente.');
    }

    public function edit(Level $level)
    {
        return view('modules.settings.levels.edit', compact('level'));
    }

    public function update(UpdateLevelRequest $request, Level $level)
    {
        $level->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('settings.levels.index')
            ->with('success', 'Nivel actualizado correctamente.');
    }

    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()
            ->route('settings.levels.index')
            ->with('success', 'Nivel eliminado correctamente.');
    }
}
