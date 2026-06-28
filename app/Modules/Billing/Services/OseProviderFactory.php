<?php

namespace App\Modules\Billing\Services;

class OseProviderFactory
{
    public function make(string $provider): OseProviderInterface
    {
        return match ($provider) {
            'nubefact' => new NubefactOseProvider,
            default => new DemoOseProvider,
        };
    }
}
