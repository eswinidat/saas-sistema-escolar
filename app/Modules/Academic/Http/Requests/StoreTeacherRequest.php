<?php

namespace App\Modules\Academic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialty' => ['nullable', 'string', 'max:150'],
            'hire_date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:active,inactive,on_leave'],
        ];
    }
}
