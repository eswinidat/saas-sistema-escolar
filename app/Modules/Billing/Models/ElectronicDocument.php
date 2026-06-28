<?php

namespace App\Modules\Billing\Models;

use App\Models\School;
use App\Models\User;
use App\Modules\Core\Traits\BelongsToSchool;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Treasury\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectronicDocument extends Model
{
    use BelongsToSchool;

    public const TYPES = [
        '01' => 'Factura electrónica',
        '03' => 'Boleta de venta',
        '07' => 'Nota de crédito',
    ];

    public const STATUSES = [
        'draft' => 'Borrador',
        'sent' => 'Enviado',
        'accepted' => 'Aceptado SUNAT',
        'rejected' => 'Rechazado',
        'cancelled' => 'Anulado',
    ];

    public const CUSTOMER_DOC_TYPES = [
        '1' => 'DNI',
        '6' => 'RUC',
        '4' => 'Carnet extranjería',
        '7' => 'Pasaporte',
    ];

    protected $fillable = [
        'school_id', 'payment_id', 'student_id', 'related_document_id',
        'document_type', 'series', 'number', 'full_number', 'issue_date', 'currency',
        'customer_doc_type', 'customer_doc_number', 'customer_name', 'customer_address',
        'subtotal', 'igv', 'total', 'status', 'sunat_response', 'sunat_hash', 'qr_data',
        'xml_path', 'cdr_path', 'issued_by', 'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'subtotal' => 'decimal:2',
            'igv' => 'decimal:2',
            'total' => 'decimal:2',
            'sent_at' => 'datetime',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ElectronicDocumentItem::class)->orderBy('line');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function relatedDocument(): BelongsTo
    {
        return $this->belongsTo(self::class, 'related_document_id');
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->document_type] ?? $this->document_type;
    }
}
