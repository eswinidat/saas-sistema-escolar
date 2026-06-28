<?php

use App\Modules\Academic\Http\Controllers\CourseController;
use App\Modules\Academic\Http\Controllers\ScheduleController;
use App\Modules\Academic\Http\Controllers\TeacherAssignmentController;
use App\Modules\Academic\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('academico')
    ->name('academic.')
    ->group(function () {
        Route::resource('docentes', TeacherController::class)
            ->parameters(['docentes' => 'teacher'])
            ->names('teachers');

        Route::resource('cursos', CourseController::class)
            ->parameters(['cursos' => 'course'])
            ->except(['show'])
            ->names('courses');

        Route::resource('asignaciones', TeacherAssignmentController::class)
            ->parameters(['asignaciones' => 'assignment'])
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('assignments');

        Route::resource('horarios', ScheduleController::class)
            ->parameters(['horarios' => 'schedule'])
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('schedules');
    });
