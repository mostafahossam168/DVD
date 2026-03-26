<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherWithdrawal extends Model
{
    protected $fillable = [
        'teacher_id',
        'amount',
        'note',
        'withdrawn_at',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'withdrawn_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
