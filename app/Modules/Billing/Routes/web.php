<?php

use App\Modules\Billing\Http\Controllers\ElectronicDocumentController;
use App\Modules\Billing\Http\Controllers\SunatSettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('facturacion')
    ->name('billing.')
    ->group(function () {
        Route::get('configuracion-sunat', [SunatSettingController::class, 'edit'])->name('settings.edit');
        Route::put('configuracion-sunat', [SunatSettingController::class, 'update'])->name('settings.update');

        Route::get('comprobantes', [ElectronicDocumentController::class, 'index'])->name('documents.index');
        Route::get('comprobantes/crear', [ElectronicDocumentController::class, 'create'])->name('documents.create');
        Route::post('comprobantes', [ElectronicDocumentController::class, 'store'])->name('documents.store');
        Route::get('comprobantes/{document}', [ElectronicDocumentController::class, 'show'])->name('documents.show');
        Route::post('comprobantes/{document}/enviar', [ElectronicDocumentController::class, 'send'])->name('documents.send');
        Route::get('comprobantes/{document}/pdf', [ElectronicDocumentController::class, 'pdf'])->name('documents.pdf');
        Route::get('desde-pago/{payment}', [ElectronicDocumentController::class, 'fromPayment'])->name('documents.from-payment');
    });
