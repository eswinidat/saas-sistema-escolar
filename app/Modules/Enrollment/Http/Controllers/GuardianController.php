<?php

namespace App\Modules\Enrollment\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Http\Requests\StoreGuardianRequest;
use App\Modules\Enrollment\Http\Requests\UpdateGuardianRequest;
use App\Modules\Enrollment\Models\Guardian;
use App\Modules\Enrollment\Models\Student;

class GuardianController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Apoderados']);
        }

        $guardians = Guardian::orderBy('last_name')->paginate(15);

        return view('modules.enrollment.guardians.index', compact('guardians'));
    }

    public function create()
    {
        $this->requireSchoolId();

        $students = Student::orderBy('last_name')->get();

        return view('modules.enrollment.guardians.create', [
            'schools' => $this->schoolsForSelect(),
            'selectedSchoolId' => $this->currentSchoolId(),
            'students' => $students,
            'relationships' => Guardian::RELATIONSHIPS,
        ]);
    }

    public function store(StoreGuardianRequest $request)
    {
        $data = $request->validated();
        $studentId = $data['student_id'] ?? null;
        $relationship = $data['relationship'] ?? 'apoderado';
        $isPrimary = $request->boolean('is_primary');

        unset($data['student_id'], $data['relationship'], $data['is_primary']);
        $data['is_economic_responsible'] = $request->boolean('is_economic_responsible');

        $guardian = Guardian::create($data);

        if ($studentId) {
            $guardian->students()->attach($studentId, [
                'relationship' => $relationship,
                'is_primary' => $isPrimary,
                'is_economic_responsible' => $data['is_economic_responsible'],
            ]);
        }

        return redirect()
            ->route('enrollment.guardians.index')
            ->with('success', 'Apoderado registrado correctamente.');
    }

    public function edit(Guardian $guardian)
    {
        return view('modules.enrollment.guardians.edit', compact('guardian'));
    }

    public function update(UpdateGuardianRequest $request, Guardian $guardian)
    {
        $guardian->update([
            ...$request->validated(),
            'is_economic_responsible' => $request->boolean('is_economic_responsible'),
        ]);

        return redirect()
            ->route('enrollment.guardians.index')
            ->with('success', 'Apoderado actualizado correctamente.');
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();

        return redirect()
            ->route('enrollment.guardians.index')
            ->with('success', 'Apoderado eliminado correctamente.');
    }
}
