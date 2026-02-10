<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name', 'status', 'stage_id'];
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
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
