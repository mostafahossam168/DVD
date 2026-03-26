<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'payment_method_id',
        'amount',
        'category',
        'description',
        'expense_date',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

