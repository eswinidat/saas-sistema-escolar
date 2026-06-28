<?php

namespace App\Modules\Billing\Services;

use App\Models\School;
use App\Modules\Billing\Models\ElectronicDocument;
use App\Modules\Billing\Models\SunatSetting;
use Barryvdh\DomPDF\Facade\Pdf;

class ElectronicDocumentPdfService
{
    public function download(ElectronicDocument $document)
    {
        $document->load(['items', 'school']);
        $settings = SunatSetting::where('school_id', $document->school_id)->first();
        $school = School::find($document->school_id);

        $pdf = Pdf::loadView('modules.billing.pdf.comprobante', [
            'document' => $document,
            'settings' => $settings,
            'school' => $school,
        ])->setPaper('a4');

        return $pdf->download($document->full_number.'.pdf');
    }
}
