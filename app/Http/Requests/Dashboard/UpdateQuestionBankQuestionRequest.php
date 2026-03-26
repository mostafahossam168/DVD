<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionBankQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_text' => ['required', 'string'],
            'type' => ['required', 'in:mcq,true_false,text'],
            'default_mark' => ['nullable', 'integer', 'min:1'],
            'answers' => ['nullable', 'array', 'required_if:type,mcq'],
            'answers.*' => ['nullable', 'string', 'max:255'],
            'correct_answer' => ['nullable', 'string', 'required_unless:type,mcq', 'max:255'],
            'correct_answer_radio' => ['nullable', 'required_if:type,mcq', 'integer', 'min:1'],
            'difficulty' => ['nullable', 'in:easy,medium,hard'],
            'teacher_id' => ['nullable', 'integer', 'exists:users,id'],
            'stage_id' => ['required', 'integer', 'exists:stages,id'],
            'grade_id' => ['required', 'integer', 'exists:grades,id'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'status' => ['required', 'boolean'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:question_categories,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
