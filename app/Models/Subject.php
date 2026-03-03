<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'status', 'image', 'grade_id'];
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teachers', 'subject_id', 'teacher_id');
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
