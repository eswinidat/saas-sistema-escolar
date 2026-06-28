<?php

use App\Modules\Grades\Http\Controllers\CompetencyController;
use App\Modules\Grades\Http\Controllers\GradeEntryController;
use App\Modules\Grades\Http\Controllers\GradingPeriodController;
use Illuminate\Support\Facades\Route;

Route::prefix('notas')
    ->name('grades.')
    ->group(function () {
        Route::resource('periodos', GradingPeriodController::class)
            ->parameters(['periodos' => 'period'])
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('periods');

        Route::resource('competencias', CompetencyController::class)
            ->parameters(['competencias' => 'competency'])
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('competencies');

        Route::get('registro', [GradeEntryController::class, 'create'])->name('entry.create');
        Route::post('registro', [GradeEntryController::class, 'store'])->name('entry.store');
        Route::get('boleta', [GradeEntryController::class, 'report'])->name('report');

        Route::get('libreta', [\App\Modules\Grades\Http\Controllers\ReportCardController::class, 'index'])->name('libreta.index');
        Route::get('libreta/pdf', [\App\Modules\Grades\Http\Controllers\ReportCardController::class, 'pdf'])->name('libreta.pdf');
        Route::get('libreta/vista', [\App\Modules\Grades\Http\Controllers\ReportCardController::class, 'preview'])->name('libreta.preview');
    });
