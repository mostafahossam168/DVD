<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'subject_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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
