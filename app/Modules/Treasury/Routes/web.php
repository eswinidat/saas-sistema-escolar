<?php

use App\Modules\Treasury\Http\Controllers\PaymentConceptController;
use App\Modules\Treasury\Http\Controllers\PaymentController;
use App\Modules\Treasury\Http\Controllers\StudentChargeController;
use Illuminate\Support\Facades\Route;

Route::prefix('tesoreria')
    ->name('treasury.')
    ->group(function () {
        Route::resource('conceptos', PaymentConceptController::class)
            ->parameters(['conceptos' => 'concept'])
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('concepts');

        Route::resource('cobros', StudentChargeController::class)
            ->parameters(['cobros' => 'charge'])
            ->only(['index', 'create', 'store'])
            ->names('charges');

        Route::resource('pagos', PaymentController::class)
            ->parameters(['pagos' => 'payment'])
            ->only(['index', 'create', 'store'])
            ->names('payments');
    });
