<?php

namespace App\Modules\Attendance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyAttendanceRequest extends FormRequest
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
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'date' => ['required', 'date'],
            'records' => ['required', 'array', 'min:1'],
            'records.*.student_id' => ['required', 'exists:students,id'],
            'records.*.status' => ['required', 'string', 'in:present,absent,late,justified,excused'],
            'records.*.check_in_time' => ['nullable', 'date_format:H:i'],
            'records.*.check_out_time' => ['nullable', 'date_format:H:i'],
            'records.*.tardiness_minutes' => ['nullable', 'integer', 'min:0'],
            'records.*.justification' => ['nullable', 'string', 'max:500'],
        ];
    }
}
