<?php

namespace App\Models;

use App\Models\Lecture;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'lecture_id',
        'title',
        'file',
        'status',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
