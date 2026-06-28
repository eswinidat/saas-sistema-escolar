<?php

namespace App\Modules\Academic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'day_of_week' => ['required', 'integer', 'between:1,6'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'classroom' => ['nullable', 'string', 'max:50'],
        ];
    }
}
