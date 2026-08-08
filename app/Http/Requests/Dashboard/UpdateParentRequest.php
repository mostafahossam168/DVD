<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $parentId = $this->route('parent');

        return [
            'f_name' => ['required', 'string', 'min:3', 'max:255'],
            'l_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $parentId],
            'phone' => ['required', 'string', 'unique:users,phone,' . $parentId],
            'image' => ['nullable', 'mimes:jpg,png'],
            'status' => ['required', 'boolean'],
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
            'children' => ['nullable', 'array'],
            'children.*' => ['exists:users,id'],
        ];
    }
}
