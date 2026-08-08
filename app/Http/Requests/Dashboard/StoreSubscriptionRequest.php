<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'status' => ['required', 'boolean'],
            'period_type' => ['required', 'in:term,month'],
            'term_number' => ['required_if:period_type,term', 'nullable', 'integer', 'min:1', 'max:3'],
            'start_date' => ['required_if:period_type,month', 'nullable', 'date'],
            'end_date' => ['required_if:period_type,month', 'nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}
