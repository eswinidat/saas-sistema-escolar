<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}