<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'subject_field',
        'rating',
        'review_text',
        'image',
        'subject_id',
        'status',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'status' => 'boolean',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }
}
