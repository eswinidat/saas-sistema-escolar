<?php

namespace App\Support;

use App\Models\User;

class AdminPanel
{
    public static function type(?User $user = null): string
    {
        $user ??= auth()->user();

        if (! $user) {
            return 'school';
        }

        if ($user->hasRole('Super Administrador')) {
            return 'super';
        }

        if ($user->hasRole('Docente')) {
            return 'teacher';
        }

        if ($user->hasRole('Estudiante')) {
            return 'student';
        }

        return 'school';
    }

    public static function label(?User $user = null): string
    {
        return match (self::type($user)) {
            'super' => 'Panel SaaS',
            'teacher' => 'Panel Docente',
            'student' => 'Panel Estudiante',
            default => 'Panel Colegio',
        };
    }

    public static function canAccessSchoolModules(?User $user = null): bool
    {
        $user ??= auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole('Super Administrador')) {
            return (bool) session('current_school_id');
        }

        return (bool) $user->school_id;
    }
}
