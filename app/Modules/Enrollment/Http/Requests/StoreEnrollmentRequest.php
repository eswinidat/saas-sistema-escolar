<?php

namespace App\Modules\Enrollment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'student_id' => ['required', 'exists:students,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'turn_id' => ['nullable', 'exists:turns,id'],
            'enrollment_number' => ['nullable', 'string', 'max:30'],
            'enrollment_date' => ['required', 'date'],
            'type' => ['required', 'string', 'in:new,ratification,reservation,transfer'],
            'status' => ['required', 'string', 'in:active,withdrawn,transferred,completed'],
            'observations' => ['nullable', 'string'],
        ];
    }
}
