<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'title',
        'type',
        'teacher_id',
        'stage_id',
        'grade_id',
        'subject_id',
        'start_time',
        'end_time',
        'duration',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'duration' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function questions()
    {
        return $this->belongsToMany(QuestionBankQuestion::class, 'assessment_question', 'assessment_id', 'question_id')
            ->withPivot(['mark', 'order'])
            ->withTimestamps()
            ->orderByPivot('order');
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
