<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'title',
        'subject_id',
        'description',
        'link',
        'status',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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
