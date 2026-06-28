<?php

namespace App\Modules\Billing\Services;

class OseResponse
{
    public function __construct(
        public bool $success,
        public string $status,
        public ?string $hash = null,
        public ?string $qrData = null,
        public ?string $message = null,
        public ?string $xmlPath = null,
        public ?string $cdrPath = null,
    ) {}
}
