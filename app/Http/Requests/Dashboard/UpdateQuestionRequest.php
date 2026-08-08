<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'max:255'],
            'quize_id' => ['required', 'exists:quizes,id'],
            'status' => ['required', 'boolean'],
            'type' => ['required'],
            'grade' => ['required', 'integer', 'min:1'],
            'correct_answer' => ['nullable', 'required_if:type,text', 'string'],
            'answers' => ['nullable', 'required_if:type,mcq', 'array'],
            'correct_answer_radio' => ['required_if:type,mcq'],
        ];
    }
}
