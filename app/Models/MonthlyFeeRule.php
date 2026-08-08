<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyFeeRule extends Model
{
    protected $fillable = ['grade_id', 'subject_id', 'amount', 'due_day', 'starts_on', 'ends_on', 'is_active'];
    protected $casts = ['amount' => 'decimal:2', 'starts_on' => 'date', 'ends_on' => 'date', 'is_active' => 'boolean'];

    public function grade() { return $this->belongsTo(Grade::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
}
