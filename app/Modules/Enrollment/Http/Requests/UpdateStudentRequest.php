<?php

namespace App\Modules\Enrollment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'string', 'max:20'],
            'document_number' => ['required', 'string', 'max:20'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:20'],
            'blood_type' => ['nullable', 'string', 'max:5'],
            'address' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', 'string', 'in:active,inactive,transferred,withdrawn'],
        ];
    }
}
