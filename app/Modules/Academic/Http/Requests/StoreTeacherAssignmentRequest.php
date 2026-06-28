<?php

namespace App\Modules\Academic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'hours_per_week' => ['nullable', 'integer', 'min:1', 'max:40'],
            'is_active' => ['boolean'],
        ];
    }
}
