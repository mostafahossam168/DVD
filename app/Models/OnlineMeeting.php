<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'stage_id',
        'grade_id',
        'subject_id',
        'topic',
        'start_time',
        'duration',
        'zoom_meeting_id',
        'join_url',
        'start_url',
        'password',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

