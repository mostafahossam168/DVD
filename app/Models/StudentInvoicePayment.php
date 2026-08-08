<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInvoicePayment extends Model
{
    protected $fillable = ['student_monthly_invoice_id', 'payment_method_id', 'received_by', 'amount', 'paid_at', 'reference', 'notes'];
    protected $casts = ['amount' => 'decimal:2', 'paid_at' => 'datetime'];

    public function invoice() { return $this->belongsTo(StudentMonthlyInvoice::class, 'student_monthly_invoice_id'); }
    public function paymentMethod() { return $this->belongsTo(PaymentMethod::class); }
    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }
}
