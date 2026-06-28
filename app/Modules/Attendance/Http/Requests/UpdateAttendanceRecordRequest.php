<?php

namespace App\Modules\Attendance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:present,absent,late,justified,excused'],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'tardiness_minutes' => ['nullable', 'integer', 'min:0'],
            'justification' => ['nullable', 'string', 'max:500'],
        ];
    }
}
