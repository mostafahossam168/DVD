<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMonthlyInvoice extends Model
{
    protected $fillable = ['student_id', 'grade_id', 'subject_id', 'billing_month', 'due_date', 'amount_due', 'amount_paid', 'status', 'notes'];
    protected $casts = ['billing_month' => 'date', 'due_date' => 'date', 'amount_due' => 'decimal:2', 'amount_paid' => 'decimal:2'];

    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    public function grade() { return $this->belongsTo(Grade::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function payments() { return $this->hasMany(StudentInvoicePayment::class); }
    public function scopeOverdue($query) { return $query->whereIn('status', ['unpaid', 'partial'])->whereDate('due_date', '<', today()); }
}
