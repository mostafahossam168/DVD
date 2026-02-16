<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'quize_id', 'type', 'answers', 'grade', 'correct_answer', 'status'];


    public function quize()
    {
        return $this->belongsTo(Quize::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }
    public function scopeInactive($q)
    {
        return $q->where('status', false);
    }


    public function casts(): array
    {
        return [
            'answers' => 'array',
        ];
    }
}
