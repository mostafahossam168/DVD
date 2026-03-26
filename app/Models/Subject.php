<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'status', 'image', 'grade_id', 'teacher_id', 'price'];

    protected $casts = [
        'price' => 'decimal:2',
    ];
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function onlineMeetings()
    {
        return $this->hasMany(\App\Models\OnlineMeeting::class);
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
