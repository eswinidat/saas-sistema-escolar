<?php

use App\Modules\Attendance\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('asistencia')
    ->name('attendance.')
    ->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/registro', [AttendanceController::class, 'take'])->name('take');
        Route::post('/registro', [AttendanceController::class, 'store'])->name('store');
        Route::get('/{attendanceRecord}/editar', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/{attendanceRecord}', [AttendanceController::class, 'update'])->name('update');
    });
