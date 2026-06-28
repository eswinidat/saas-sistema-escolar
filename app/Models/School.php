<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'name',
        'code',
        'ruc',
        'modular_code',
        'phone',
        'email',
        'website',
        'address',
        'district',
        'province',
        'department',
        'principal_name',
        'logo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function academicYears(): HasMany
    {
        return $this->hasMany(\App\Modules\Settings\Models\AcademicYear::class);
    }

    public function levels(): HasMany
    {
        return $this->hasMany(\App\Modules\Settings\Models\Level::class);
    }

    public function turns(): HasMany
    {
        return $this->hasMany(\App\Modules\Settings\Models\Turn::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(\App\Modules\Enrollment\Models\Student::class);
    }
}