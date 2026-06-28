<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50|unique:schools,code,' . $this->school->id,
        'ruc' => 'nullable|digits:11|unique:schools,ruc,' . $this->school->id,
        'modular_code' => 'nullable|string|max:50',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'department' => 'nullable|string|max:100',
        'principal_name' => 'nullable|string|max:255',
        'logo' => 'nullable|string|max:255',
        'status' => 'boolean',
        ];
    }
}
