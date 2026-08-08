<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'f_name' => ['required', 'string', 'min:3', 'max:255'],
            'l_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'phone' => ['required', 'string', 'unique:users,phone,' . $userId],
            'image' => ['nullable', 'mimes:jpg,png'],
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ];
    }
}
