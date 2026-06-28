<?php

namespace App\Modules\Treasury\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Treasury\Models\PaymentConcept;
use Illuminate\Http\Request;

class PaymentConceptController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Conceptos de pago']);
        }

        $concepts = PaymentConcept::orderBy('name')->paginate(15);

        return view('modules.treasury.concepts.index', compact('concepts'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.treasury.concepts.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'types' => PaymentConcept::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:30'],
            'type' => ['required', 'string'],
            'default_amount' => ['required', 'numeric', 'min:0'],
            'is_recurring' => ['boolean'],
        ]);

        PaymentConcept::create([
            ...$data,
            'is_recurring' => $request->boolean('is_recurring'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('treasury.concepts.index')->with('success', 'Concepto registrado.');
    }

    public function destroy(PaymentConcept $concept)
    {
        $concept->delete();

        return redirect()->route('treasury.concepts.index')->with('success', 'Concepto eliminado.');
    }
}
