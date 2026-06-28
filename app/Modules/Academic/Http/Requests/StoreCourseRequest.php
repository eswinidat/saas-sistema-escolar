<?php

namespace App\Modules\Academic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'grade_id' => ['nullable', 'exists:grades,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'hours_per_week' => ['nullable', 'integer', 'min:1', 'max:40'],
            'is_active' => ['boolean'],
        ];
    }
}
