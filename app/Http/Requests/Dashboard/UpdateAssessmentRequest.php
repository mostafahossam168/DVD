<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:exam,quiz,assignment'],
            'teacher_id' => ['nullable', 'integer', 'exists:users,id'],
            'stage_id' => ['required', 'integer', 'exists:stages,id'],
            'grade_id' => ['required', 'integer', 'exists:grades,id'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date', 'after_or_equal:start_time'],
            'duration' => ['nullable', 'integer', 'min:1', 'max:600'],
            'status' => ['required', 'boolean'],
        ];
    }
}
