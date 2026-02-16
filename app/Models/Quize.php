<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quize extends Model
{
    protected $fillable = ['title', 'lecture_id', 'start_time', 'end_time', 'status'];


    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function ScopeActive($q)
    {
        return $q->where('status', true);
    }
    public function ScopeInActive($q)
    {
        return $q->where('status', false);
    }
}
