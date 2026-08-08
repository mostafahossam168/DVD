<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'f_name' => ['required', 'string', 'min:3', 'max:255'],
            'l_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'image' => ['nullable', 'mimes:jpg,png'],
            'status' => ['required', 'boolean'],
            'password' => ['required', 'min:3', 'confirmed', 'string'],
        ];
    }
}
