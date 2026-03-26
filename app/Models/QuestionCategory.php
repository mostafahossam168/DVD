<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function questions()
    {
        return $this->belongsToMany(QuestionBankQuestion::class, 'question_bank_question_category', 'category_id', 'question_id')
            ->withTimestamps();
    }
}
