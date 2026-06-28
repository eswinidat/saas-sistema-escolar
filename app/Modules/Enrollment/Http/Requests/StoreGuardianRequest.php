<?php

namespace App\Modules\Enrollment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuardianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'document_type' => ['required', 'string', 'max:20'],
            'document_number' => ['required', 'string', 'max:20'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'is_economic_responsible' => ['boolean'],
            'student_id' => ['nullable', 'exists:students,id'],
            'relationship' => ['nullable', 'string', 'max:50'],
            'is_primary' => ['boolean'],
        ];
    }
}
