<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AttachAssessmentQuestionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->type, ['admin', 'teacher'], true);
    }

    public function rules(): array
    {
        return [
            'questions' => ['nullable', 'array'],
            'questions.*.question_id' => ['required_with:questions', 'integer', 'exists:question_bank_questions,id', 'distinct'],
            'questions.*.mark' => ['nullable', 'integer', 'min:1'],
            'questions.*.order' => ['nullable', 'integer', 'min:1'],

            'random' => ['nullable', 'array'],
            'random.enabled' => ['nullable', 'boolean'],
            'random.count' => ['required_with:random', 'integer', 'min:1'],
            'random.difficulty' => ['nullable', 'in:easy,medium,hard'],
            'random.category_ids' => ['nullable', 'array'],
            'random.category_ids.*' => ['integer', 'exists:question_categories,id'],
        ];
    }
}
