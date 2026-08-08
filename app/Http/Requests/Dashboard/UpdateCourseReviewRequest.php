<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subject_field' => ['nullable', 'string', 'max:100'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'review_text' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'status' => ['required', 'boolean'],
        ];
    }
}
