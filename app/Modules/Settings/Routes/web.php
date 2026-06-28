<?php

use App\Modules\Settings\Http\Controllers\AcademicYearController;
use App\Modules\Settings\Http\Controllers\GradeController;
use App\Modules\Settings\Http\Controllers\LevelController;
use App\Modules\Settings\Http\Controllers\SectionController;
use App\Modules\Settings\Http\Controllers\TurnController;
use Illuminate\Support\Facades\Route;

Route::prefix('configuracion')
    ->name('settings.')
    ->group(function () {
        Route::resource('anios-academicos', AcademicYearController::class)
            ->parameters(['anios-academicos' => 'academicYear'])
            ->names('academic-years');

        Route::resource('niveles', LevelController::class)
            ->parameters(['niveles' => 'level'])
            ->names('levels');

        Route::resource('grados', GradeController::class)
            ->parameters(['grados' => 'grade'])
            ->names('grades');

        Route::resource('secciones', SectionController::class)
            ->parameters(['secciones' => 'section'])
            ->names('sections');

        Route::resource('turnos', TurnController::class)
            ->parameters(['turnos' => 'turn'])
            ->names('turns');
    });
