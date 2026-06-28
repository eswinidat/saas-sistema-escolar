<?php

namespace App\Modules\Billing\Services;

use App\Modules\Billing\Models\ElectronicDocument;

interface OseProviderInterface
{
    public function send(ElectronicDocument $document): OseResponse;
}
