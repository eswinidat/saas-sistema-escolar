<?php

namespace App\Modules\Settings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'grade_id' => ['required', 'exists:grades,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'turn_id' => ['nullable', 'exists:turns,id'],
            'name' => ['required', 'string', 'max:50'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'tutor_name' => ['nullable', 'string', 'max:150'],
            'is_active' => ['boolean'],
        ];
    }
}
