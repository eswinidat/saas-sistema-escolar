<?php

namespace App\Modules\Billing\Services;

use App\Modules\Billing\Models\ElectronicDocument;
use Illuminate\Support\Str;

class DemoOseProvider implements OseProviderInterface
{
    public function send(ElectronicDocument $document): OseResponse
    {
        $document->loadMissing('school');
        $hash = strtoupper(Str::random(40));
        $qr = implode('|', [
            $document->school->ruc ?? '00000000000',
            $document->document_type,
            $document->series,
            $document->number,
            number_format($document->igv, 2, '.', ''),
            number_format($document->total, 2, '.', ''),
            $document->issue_date->format('Y-m-d'),
            $document->customer_doc_type,
            $document->customer_doc_number,
        ]);

        return new OseResponse(
            success: true,
            status: 'accepted',
            hash: $hash,
            qrData: $qr,
            message: 'Comprobante aceptado (modo demo). Configure un OSE real para producción.',
            xmlPath: null,
            cdrPath: null,
        );
    }
}
