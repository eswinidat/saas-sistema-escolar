<?php

use App\Modules\Portal\Http\Controllers\Api\ParentApiController;
use App\Modules\Portal\Http\Controllers\Api\ParentAuthController;
use App\Modules\Portal\Http\Middleware\EnsureParentRole;
use Illuminate\Support\Facades\Route;

Route::post('/v1/portal/login', [ParentAuthController::class, 'login']);

Route::prefix('v1/portal')
    ->middleware(['auth:sanctum', EnsureParentRole::class])
    ->group(function () {
        Route::post('/logout', [ParentAuthController::class, 'logout']);
        Route::get('/students', [ParentApiController::class, 'students']);
        Route::get('/students/{studentId}/grades', [ParentApiController::class, 'grades']);
        Route::get('/students/{studentId}/attendance', [ParentApiController::class, 'attendance']);
        Route::get('/students/{studentId}/payments', [ParentApiController::class, 'payments']);
    });
