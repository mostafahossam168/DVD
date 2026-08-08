<?php

namespace App\Http\Requests\Dashboard;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $walletIds = PaymentMethod::active()
            ->whereIn('code', ['vodafone_cash', 'instapay'])
            ->pluck('id')
            ->toArray();

        return [
            'payment_method_id' => ['required', 'integer', 'in:' . implode(',', $walletIds)],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:191'],
            'expense_date' => ['required', 'date'],
        ];
    }
}
