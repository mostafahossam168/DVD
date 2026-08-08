<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureProgress extends Model
{
    protected $fillable = [
        'user_id',
        'lecture_id',
        'last_position_seconds',
        'duration_seconds',
        'percent_watched',
        'completed',
        'last_watched_at',
    ];

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'last_watched_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
