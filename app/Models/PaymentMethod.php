<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'code', 'account_name', 'account_number', 'notes', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
