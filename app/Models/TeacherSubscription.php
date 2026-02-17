<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeacherSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }

    public function scopeInactive($q)
    {
        return $q->where('status', false);
    }
}
