<?php

namespace App\Modules\Treasury\Http\Controllers;

use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Treasury\Models\Payment;
use App\Modules\Treasury\Models\StudentCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends ModuleController
{
    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Pagos']);
        }

        $payments = Payment::with(['student', 'studentCharge.paymentConcept'])
            ->orderByDesc('payment_date')
            ->paginate(20);

        return view('modules.treasury.payments.index', compact('payments'));
    }

    public function create()
    {
        $this->requireSchoolId();

        $studentId = request('student_id');

        return view('modules.treasury.payments.create', [
            'selectedSchoolId' => $this->currentSchoolId(),
            'students' => Student::where('status', 'active')->orderBy('last_name')->get(),
            'charges' => StudentCharge::with('paymentConcept')
                ->when($studentId, fn ($q) => $q->where('student_id', $studentId))
                ->whereIn('status', ['pending', 'partial', 'overdue'])
                ->orderBy('due_date')
                ->get(),
            'methods' => Payment::METHODS,
            'selectedStudentId' => $studentId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'student_id' => ['required', 'exists:students,id'],
            'student_charge_id' => ['nullable', 'exists:student_charges,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'string'],
            'receipt_number' => ['nullable', 'string', 'max:50'],
            'observations' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $payment = Payment::create([
                ...$data,
                'recorded_by' => $request->user()->id,
            ]);

            if (! empty($data['student_charge_id'])) {
                $charge = StudentCharge::find($data['student_charge_id']);
                if ($charge) {
                    $charge->paid_amount = (float) $charge->paid_amount + (float) $data['amount'];
                    $charge->refreshStatus();
                }
            }
        });

        return redirect()->route('treasury.payments.index')->with('success', 'Pago registrado.');
    }
}
