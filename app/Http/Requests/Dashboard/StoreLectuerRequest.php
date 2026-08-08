<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreLectuerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'description' => ['required', 'string', 'min:5'],
            'link' => ['required', 'url'],
            'status' => ['required', 'boolean'],
        ];
    }
}
