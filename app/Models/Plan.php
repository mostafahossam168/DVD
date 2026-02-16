<?php

namespace App\Models;

use App\Models\TeacherSubscription;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'subjects_limit',
        'students_limit',
        'status'
    ];

    public function subscriptions()
    {
        return $this->hasMany(TeacherSubscription::class);
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
