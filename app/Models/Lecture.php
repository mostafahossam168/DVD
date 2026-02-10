<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'subject_id',
        'title',
        'description',
        'link',
        'status',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
