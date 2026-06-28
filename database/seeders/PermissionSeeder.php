<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules = [
            'users',
            'roles',
            'schools',
            'academic_years',
            'levels',
            'turns',
            'students',
            'teachers',
            'parents',
            'courses',
            'grades',
            'sections',
            'subjects',
            'enrollments',
            'attendance',
            'evaluations',
            'payments',
            'reports',
        ];

        $actions = [

            'view',
            'create',
            'edit',
            'delete',

        ];

        foreach ($modules as $module) {

            foreach ($actions as $action) {

                Permission::firstOrCreate([

                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',

                ]);

            }

        }
    }
}