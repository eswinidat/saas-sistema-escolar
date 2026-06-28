<?php

use App\Modules\Portal\Http\Controllers\PortalDashboardController;
use App\Modules\Portal\Http\Middleware\EnsureParentRole;
use Illuminate\Support\Facades\Route;

Route::prefix('portal')
    ->name('portal.')
    ->middleware([EnsureParentRole::class, \App\Http\Middleware\HandleInertiaRequests::class])
    ->group(function () {
        Route::get('/', [PortalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/notas', [PortalDashboardController::class, 'grades'])->name('grades');
        Route::get('/libreta/pdf', [PortalDashboardController::class, 'libretaPdf'])->name('libreta.pdf');
        Route::get('/asistencia', [PortalDashboardController::class, 'attendance'])->name('attendance');
        Route::get('/pagos', [PortalDashboardController::class, 'payments'])->name('payments');
    });
