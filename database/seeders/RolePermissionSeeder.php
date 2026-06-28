<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::findByName('Super Administrador');
        $superAdmin->syncPermissions(Permission::all());

        $schoolAdmin = Role::findByName('Administrador Colegio');
        $schoolAdmin->syncPermissions(
            Permission::whereIn('name', $this->schoolAdminPermissions())->get()
        );

        $secretary = Role::findByName('Secretaria');
        $secretary->syncPermissions(
            Permission::whereIn('name', $this->secretaryPermissions())->get()
        );
    }

    protected function schoolAdminPermissions(): array
    {
        $modules = [
            'students', 'parents', 'enrollments', 'academic_years',
            'levels', 'grades', 'sections', 'turns', 'teachers', 'courses',
            'attendance', 'evaluations', 'payments', 'billing', 'reports',
        ];

        return $this->crudPermissions($modules);
    }

    protected function secretaryPermissions(): array
    {
        $modules = ['students', 'parents', 'enrollments', 'attendance', 'evaluations', 'payments', 'billing', 'reports'];

        return $this->crudPermissions($modules);
    }

    protected function crudPermissions(array $modules): array
    {
        $permissions = [];

        foreach ($modules as $module) {
            foreach (['view', 'create', 'edit', 'delete'] as $action) {
                $permissions[] = "{$module}.{$action}";
            }
        }

        return $permissions;
    }
}
