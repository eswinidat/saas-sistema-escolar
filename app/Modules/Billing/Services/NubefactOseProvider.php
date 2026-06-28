<?php

namespace App\Modules\Billing\Services;

use App\Modules\Billing\Models\ElectronicDocument;
use App\Modules\Billing\Models\SunatSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NubefactOseProvider implements OseProviderInterface
{
    public function send(ElectronicDocument $document): OseResponse
    {
        $settings = SunatSetting::where('school_id', $document->school_id)->first();

        if (! $settings?->ose_api_url || ! $settings?->ose_api_token) {
            return new OseResponse(false, 'rejected', message: 'Configure URL y token del OSE Nubefact.');
        }

        try {
            $payload = $this->buildPayload($document);

            $response = Http::withToken($settings->ose_api_token)
                ->timeout(30)
                ->post(rtrim($settings->ose_api_url, '/').'/comprobantes', $payload);

            if ($response->successful() && ($response->json('aceptada_por_sunat') ?? false)) {
                return new OseResponse(
                    success: true,
                    status: 'accepted',
                    hash: $response->json('hash'),
                    qrData: $response->json('cadena_para_codigo_qr'),
                    message: 'Aceptado por SUNAT vía Nubefact.',
                );
            }

            return new OseResponse(
                success: false,
                status: 'rejected',
                message: $response->json('errors') ?? $response->body(),
            );
        } catch (\Throwable $e) {
            Log::error('Nubefact OSE error', ['error' => $e->getMessage()]);

            return new OseResponse(false, 'rejected', message: $e->getMessage());
        }
    }

    protected function buildPayload(ElectronicDocument $document): array
    {
        return [
            'tipo_de_comprobante' => (int) $document->document_type,
            'serie' => $document->series,
            'numero' => $document->number,
            'sunat_transaction' => 1,
            'cliente_tipo_de_documento' => (int) $document->customer_doc_type,
            'cliente_numero_de_documento' => $document->customer_doc_number,
            'cliente_denominacion' => $document->customer_name,
            'cliente_direccion' => $document->customer_address,
            'fecha_de_emision' => $document->issue_date->format('d-m-Y'),
            'moneda' => 1,
            'porcentaje_de_igv' => 18,
            'total_gravada' => (float) $document->subtotal,
            'total_igv' => (float) $document->igv,
            'total' => (float) $document->total,
            'items' => $document->items->map(fn ($item) => [
                'unidad_de_medida' => 'NIU',
                'descripcion' => $item->description,
                'cantidad' => (float) $item->quantity,
                'valor_unitario' => round((float) $item->unit_price / 1.18, 2),
                'precio_unitario' => (float) $item->unit_price,
                'subtotal' => (float) $item->subtotal,
                'tipo_de_igv' => 1,
                'igv' => (float) $item->igv,
                'total' => (float) $item->total,
            ])->values()->all(),
        ];
    }
}
