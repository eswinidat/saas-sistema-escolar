<?php

namespace App\Modules\Billing\Http\Controllers;

use App\Modules\Billing\Models\ElectronicDocument;
use App\Modules\Billing\Models\SunatSetting;
use App\Modules\Billing\Services\ElectronicDocumentPdfService;
use App\Modules\Billing\Services\ElectronicDocumentService;
use App\Modules\Core\Http\Controllers\ModuleController;
use App\Modules\Enrollment\Models\Guardian;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Treasury\Models\Payment;
use Illuminate\Http\Request;

class ElectronicDocumentController extends ModuleController
{
    public function __construct(
        protected ElectronicDocumentService $documentService,
        protected ElectronicDocumentPdfService $pdfService,
    ) {}

    public function index()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Comprobantes electrónicos']);
        }

        $documents = ElectronicDocument::with('student')
            ->orderByDesc('issue_date')
            ->orderByDesc('id')
            ->paginate(20);

        return view('modules.billing.documents.index', compact('documents'));
    }

    public function create(Request $request)
    {
        $schoolId = $this->requireSchoolId();
        SunatSetting::where('school_id', $schoolId)->firstOrFail();

        $docType = $request->input('document_type', '03');
        $numbering = $this->documentService->nextNumber($schoolId, $docType);

        $payment = $request->filled('payment_id')
            ? Payment::with('student.guardians')->find($request->payment_id)
            : null;

        return view('modules.billing.documents.create', [
            'selectedSchoolId' => $schoolId,
            'types' => ElectronicDocument::TYPES,
            'customerDocTypes' => ElectronicDocument::CUSTOMER_DOC_TYPES,
            'docType' => $docType,
            'series' => $numbering['series'],
            'number' => $numbering['number'],
            'payment' => $payment,
            'students' => Student::where('status', 'active')->orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $schoolId = $this->requireSchoolId();
        $docType = $request->input('document_type', '03');
        $numbering = $this->documentService->nextNumber($schoolId, $docType);

        $data = $request->validate([
            'document_type' => ['required', 'in:01,03,07'],
            'issue_date' => ['required', 'date'],
            'customer_doc_type' => ['required', 'in:1,4,6,7'],
            'customer_doc_number' => ['required', 'string', 'max:15'],
            'customer_name' => ['required', 'string', 'max:200'],
            'customer_address' => ['nullable', 'string'],
            'payment_id' => ['nullable', 'exists:payments,id'],
            'student_id' => ['nullable', 'exists:students,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0.01'],
        ]);

        $document = $this->documentService->create([
            'school_id' => $schoolId,
            'document_type' => $data['document_type'],
            'series' => $numbering['series'],
            'number' => $numbering['number'],
            'issue_date' => $data['issue_date'],
            'customer_doc_type' => $data['customer_doc_type'],
            'customer_doc_number' => $data['customer_doc_number'],
            'customer_name' => $data['customer_name'],
            'customer_address' => $data['customer_address'] ?? null,
            'payment_id' => $data['payment_id'] ?? null,
            'student_id' => $data['student_id'] ?? null,
        ], $data['items'], $request->user()->id);

        return redirect()->route('billing.documents.show', $document)
            ->with('success', 'Comprobante creado. Envíelo a SUNAT cuando esté listo.');
    }

    public function show(ElectronicDocument $document)
    {
        $document->load(['items', 'student', 'payment', 'issuedBy']);

        return view('modules.billing.documents.show', compact('document'));
    }

    public function send(ElectronicDocument $document)
    {
        abort_unless($document->status === 'draft', 422, 'Solo se pueden enviar borradores.');

        $response = $this->documentService->sendToSunat($document);

        return redirect()->route('billing.documents.show', $document)
            ->with($response->success ? 'success' : 'error', $response->message);
    }

    public function pdf(ElectronicDocument $document)
    {
        return $this->pdfService->download($document);
    }

    public function fromPayment(Payment $payment)
    {
        $payment->load('student');
        $student = $payment->student;
        $guardian = $student?->guardians()->wherePivot('is_economic_responsible', true)->first()
            ?? $student?->guardians()->first();

        return redirect()->route('billing.documents.create', [
            'payment_id' => $payment->id,
            'document_type' => strlen($guardian?->document_number ?? '') === 11 ? '01' : '03',
        ]);
    }
}
