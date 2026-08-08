<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('admin');

        return [
            'f_name' => ['required', 'string', 'min:3', 'max:255'],
            'l_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $adminId],
            'phone' => ['required', 'string', 'unique:users,phone,' . $adminId],
            'image' => ['nullable', 'mimes:jpg,png'],
            'status' => ['required', 'boolean'],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ];
    }
}
