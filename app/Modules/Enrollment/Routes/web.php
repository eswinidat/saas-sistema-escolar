<?php

use App\Modules\Enrollment\Http\Controllers\EnrollmentController;
use App\Modules\Enrollment\Http\Controllers\GuardianController;
use App\Modules\Enrollment\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('matricula')
    ->name('enrollment.')
    ->group(function () {
        Route::resource('alumnos', StudentController::class)
            ->parameters(['alumnos' => 'student'])
            ->names('students');

        Route::resource('apoderados', GuardianController::class)
            ->parameters(['apoderados' => 'guardian'])
            ->names('guardians');

        Route::resource('matriculas', EnrollmentController::class)
            ->parameters(['matriculas' => 'enrollment'])
            ->names('enrollments');
    });
