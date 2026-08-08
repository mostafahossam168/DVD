<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['price' => $this->input('price') ?: null]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'image' => ['nullable', 'image'],
            'grade_id' => ['required', 'exists:grades,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
