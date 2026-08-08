<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'f_name' => ['required', 'string', 'min:3', 'max:255'],
            'l_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $studentId],
            'phone' => ['required', 'string', 'unique:users,phone,' . $studentId],
            'image' => ['nullable', 'mimes:jpg,png'],
            'status' => ['required', 'boolean'],
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ];
    }
}
