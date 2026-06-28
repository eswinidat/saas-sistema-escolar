<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        .header { border-bottom: 2px solid #1e40af; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 16px; font-weight: bold; color: #1e40af; }
        .box { border: 1px solid #ccc; padding: 10px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f1f5f9; }
        .totals { margin-top: 12px; width: 45%; float: right; }
        .totals td { border: none; padding: 4px; }
        .qr { font-size: 8px; word-break: break-all; margin-top: 15px; border-top: 1px dashed #999; padding-top: 8px; }
        .badge { display: inline-block; padding: 3px 8px; background: #dcfce7; color: #166534; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="border:none;">
            <tr style="border:none;">
                <td style="border:none; width:60%;">
                    <div class="title">{{ $settings->business_name ?? $school->name }}</div>
                    <div>RUC: {{ $settings->ruc ?? $school->ruc }}</div>
                    <div>{{ $settings->address ?? $school->address }}</div>
                </td>
                <td style="border:none; text-align:right;">
                    <div class="title">{{ $document->typeLabel() }}</div>
                    <div><strong>{{ $document->full_number }}</strong></div>
                    <div>Fecha: {{ $document->issue_date->format('d/m/Y') }}</div>
                    @if($document->status === 'accepted')
                        <span class="badge">ACEPTADO SUNAT</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="box">
        <strong>Cliente:</strong> {{ $document->customer_name }}<br>
        <strong>{{ \App\Modules\Billing\Models\ElectronicDocument::CUSTOMER_DOC_TYPES[$document->customer_doc_type] ?? 'Doc' }}:</strong> {{ $document->customer_doc_number }}<br>
        @if($document->customer_address)
            <strong>Dirección:</strong> {{ $document->customer_address }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>P. Unit.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($document->items as $item)
                <tr>
                    <td>{{ $item->line }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>S/ {{ number_format($item->unit_price, 2) }}</td>
                    <td>S/ {{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Op. gravada:</td><td style="text-align:right;">S/ {{ number_format($document->subtotal, 2) }}</td></tr>
        <tr><td>IGV (18%):</td><td style="text-align:right;">S/ {{ number_format($document->igv, 2) }}</td></tr>
        <tr><td><strong>Total:</strong></td><td style="text-align:right;"><strong>S/ {{ number_format($document->total, 2) }}</strong></td></tr>
    </table>

    <div style="clear:both;"></div>

    @if($document->qr_data)
        <div class="qr">
            <strong>Código QR / Hash SUNAT:</strong><br>
            {{ $document->qr_data }}
            @if($document->sunat_hash)<br>Hash: {{ $document->sunat_hash }}@endif
        </div>
    @endif

    <p style="margin-top:20px; font-size:9px; color:#666; text-align:center;">
        Representación impresa del comprobante electrónico — Consulte en www.sunat.gob.pe
    </p>
</body>
</html>
