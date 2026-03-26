<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $fillable = [
        'user_id',
        'assessment_id',
        'score',
        'max_score',
        'details',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
