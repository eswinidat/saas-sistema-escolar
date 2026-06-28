<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Settings\Http\Requests\StoreTurnRequest;
use App\Modules\Settings\Http\Requests\UpdateTurnRequest;
use App\Modules\Settings\Models\Turn;

class TurnController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Turnos']);
        }

        $turns = Turn::orderBy('name')->paginate(15);

        return view('modules.settings.turns.index', compact('turns'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.settings.turns.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
        ]);
    }

    public function store(StoreTurnRequest $request)
    {
        Turn::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('settings.turns.index')
            ->with('success', 'Turno registrado correctamente.');
    }

    public function edit(Turn $turn)
    {
        return view('modules.settings.turns.edit', compact('turn'));
    }

    public function update(UpdateTurnRequest $request, Turn $turn)
    {
        $turn->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('settings.turns.index')
            ->with('success', 'Turno actualizado correctamente.');
    }

    public function destroy(Turn $turn)
    {
        $turn->delete();

        return redirect()
            ->route('settings.turns.index')
            ->with('success', 'Turno eliminado correctamente.');
    }
}
