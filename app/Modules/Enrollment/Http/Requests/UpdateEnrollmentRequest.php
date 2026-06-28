<?php

namespace App\Modules\Enrollment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
