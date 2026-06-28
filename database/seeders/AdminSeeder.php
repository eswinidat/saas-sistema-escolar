<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sistema.edu.pe'],
            [
                'name' => 'Super Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->syncRoles(['Super Administrador']);

        $school = School::firstOrCreate(
            ['ruc' => '20123456789'],
            [
                'name' => 'Colegio Demo San Martín',
                'code' => 'CDSM',
                'modular_code' => '1234567',
                'phone' => '01-4567890',
                'email' => 'info@sanmartin.edu.pe',
                'address' => 'Av. Principal 123',
                'district' => 'Miraflores',
                'province' => 'Lima',
                'department' => 'Lima',
                'principal_name' => 'Dr. Juan Pérez',
                'status' => true,
            ]
        );

        $schoolAdmin = User::firstOrCreate(
            ['email' => 'director@sanmartin.edu.pe'],
            [
                'name' => 'Director Demo',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
            ]
        );

        $schoolAdmin->syncRoles(['Administrador Colegio']);
    }
}
