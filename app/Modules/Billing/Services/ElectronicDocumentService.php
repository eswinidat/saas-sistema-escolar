<?php

namespace App\Modules\Billing\Services;

use App\Modules\Billing\Models\ElectronicDocument;
use App\Modules\Billing\Models\ElectronicDocumentItem;
use App\Modules\Billing\Models\SunatSetting;
use Illuminate\Support\Facades\DB;

class ElectronicDocumentService
{
    public const IGV_RATE = 0.18;

    public function __construct(protected OseProviderFactory $oseFactory) {}

    public function nextNumber(int $schoolId, string $documentType): array
    {
        $settings = SunatSetting::where('school_id', $schoolId)->firstOrFail();

        $series = match ($documentType) {
            '01' => $settings->factura_series,
            '07' => $settings->nota_credito_series,
            default => $settings->boleta_series,
        };

        $last = ElectronicDocument::withoutGlobalScopes()
            ->where('school_id', $schoolId)
            ->where('document_type', $documentType)
            ->where('series', $series)
            ->max('number');

        $number = ($last ?? 0) + 1;

        return compact('series', 'number');
    }

    public function create(array $data, array $items, int $userId): ElectronicDocument
    {
        return DB::transaction(function () use ($data, $items, $userId) {
            $totals = $this->calculateTotals($items);

            $document = ElectronicDocument::create([
                ...$data,
                ...$totals,
                'full_number' => $data['series'].'-'.str_pad((string) $data['number'], 8, '0', STR_PAD_LEFT),
                'status' => 'draft',
                'issued_by' => $userId,
            ]);

            foreach ($items as $i => $item) {
                $lineTotals = $this->calculateLine($item['quantity'], $item['unit_price']);
                ElectronicDocumentItem::create([
                    'electronic_document_id' => $document->id,
                    'line' => $i + 1,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    ...$lineTotals,
                ]);
            }

            return $document->load('items');
        });
    }

    public function sendToSunat(ElectronicDocument $document): OseResponse
    {
        $settings = SunatSetting::where('school_id', $document->school_id)->firstOrFail();
        $provider = $this->oseFactory->make($settings->ose_provider);
        $response = $provider->send($document->load(['items', 'school']));

        $document->update([
            'status' => $response->status,
            'sunat_hash' => $response->hash,
            'qr_data' => $response->qrData,
            'sunat_response' => $response->message,
            'xml_path' => $response->xmlPath,
            'cdr_path' => $response->cdrPath,
            'sent_at' => now(),
        ]);

        return $response;
    }

    public function calculateLine(float $quantity, float $unitPrice): array
    {
        $total = round($quantity * $unitPrice, 2);
        $subtotal = round($total / (1 + self::IGV_RATE), 2);
        $igv = round($total - $subtotal, 2);

        return compact('subtotal', 'igv', 'total');
    }

    public function calculateTotals(array $items): array
    {
        $subtotal = 0;
        $igv = 0;
        $total = 0;

        foreach ($items as $item) {
            $line = $this->calculateLine((float) $item['quantity'], (float) $item['unit_price']);
            $subtotal += $line['subtotal'];
            $igv += $line['igv'];
            $total += $line['total'];
        }

        return [
            'subtotal' => round($subtotal, 2),
            'igv' => round($igv, 2),
            'total' => round($total, 2),
        ];
    }
}
