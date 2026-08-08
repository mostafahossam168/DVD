<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'lecture_id' => ['required', 'exists:lectures,id'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'],
            'status' => ['required', 'boolean'],
        ];
    }
}
