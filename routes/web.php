<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::post('/contexto/colegio', [\App\Http\Controllers\SchoolContextController::class, 'update'])
        ->name('context.school.update');

    Route::resource('schools', SchoolController::class)
    ->middleware('role:Super Administrador');

    Route::resource('users', UserController::class)
    ->middleware('role:Super Administrador');

    Route::resource('roles', RoleController::class)
    ->middleware('role:Super Administrador');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->name('index');
        Route::get('/iniciar/{contact}', [\App\Http\Controllers\ChatController::class, 'start'])->name('start');
        Route::get('/{conversation}', [\App\Http\Controllers\ChatController::class, 'show'])->name('show');
        Route::post('/{conversation}', [\App\Http\Controllers\ChatController::class, 'store'])->name('store');
    });

});

require __DIR__.'/auth.php';