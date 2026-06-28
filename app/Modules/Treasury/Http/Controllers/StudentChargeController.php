<?php

namespace App\Modules\Treasury\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Treasury\Models\PaymentConcept;
use App\Modules\Treasury\Models\StudentCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StudentChargeController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Cobros']);
        }

        $query = StudentCharge::with(['student', 'paymentConcept'])
            ->orderByDesc('due_date');

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $charges = $query->paginate(20)->withQueryString();

        $overdueTotal = StudentCharge::whereIn('status', ['pending', 'partial', 'overdue'])
            ->where('due_date', '<', now()->toDateString())
            ->sum(DB::raw('amount - paid_amount'));

        return view('modules.treasury.charges.index', compact('charges', 'overdueTotal'));
    }

    public function create()
    {
        $this->requireSchoolId();

        return view('modules.treasury.charges.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'students' => Student::where('status', 'active')->orderBy('last_name')->get(),
            'concepts' => PaymentConcept::where('is_active', true)->orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('year')->pluck('year', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'student_id' => ['required', 'exists:students,id'],
            'payment_concept_id' => ['required', 'exists:payment_concepts,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'period_label' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $charge = StudentCharge::create([...$data, 'status' => 'pending']);
        $charge->refreshStatus();

        return redirect()->route('treasury.charges.index')->with('success', 'Cargo generado.');
    }
}
