<?php

namespace App\Modules\Settings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:20'],
            'order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
