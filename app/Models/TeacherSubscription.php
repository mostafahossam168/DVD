<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeacherSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'paln_id',
        'status',
        // 'start_date',
        // 'end_date',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
