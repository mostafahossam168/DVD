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

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }
    public function scopeInactive($q)
    {
        return $q->where('status', false);
    }
}
