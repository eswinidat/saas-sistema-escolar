<?php

namespace App\Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadModuleRoutes('Settings');
        $this->loadModuleRoutes('Enrollment');
        $this->loadModuleRoutes('Academic');
        $this->loadModuleRoutes('Attendance');
        $this->loadModuleRoutes('Grades');
        $this->loadModuleRoutes('Treasury');
        $this->loadModuleRoutes('Portal');
    }

    protected function loadModuleRoutes(string $module): void
    {
        $routesPath = app_path("Modules/{$module}/Routes/web.php");

        if (! file_exists($routesPath)) {
            return;
        }

        Route::middleware(['web', 'auth', 'verified', \App\Modules\Core\Http\Middleware\SetSchoolContext::class])
            ->group($routesPath);
    }
}
