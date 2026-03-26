<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionBankQuestion extends Model
{
    protected $table = 'question_bank_questions';

    protected $fillable = [
        'question_text',
        'answers',
        'correct_answer',
        'type',
        'default_mark',
        'difficulty',
        'teacher_id',
        'stage_id',
        'grade_id',
        'subject_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'default_mark' => 'integer',
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

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_question', 'question_id', 'assessment_id')
            ->withPivot(['mark', 'order'])
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(QuestionCategory::class, 'question_bank_question_category', 'question_id', 'category_id')
            ->withTimestamps();
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
