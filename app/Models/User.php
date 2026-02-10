<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\TeacherSubscription;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'phone',
        'image',
        'more_information',
        'type',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return trim($this->f_name . ' ' . $this->l_name);
    }

    public function scopeAdmins($q)
    {
        return $q->where('type', 'admin');
    }
    public function scopeTeachers($q)
    {
        return $q->where('type', 'teacher');
    }
    public function scopeStudents($q)
    {
        return $q->where('type', 'student');
    }

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }
    public function scopeInactive($q)
    {
        return $q->where('status', false);
    }


    public function teachingSubjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }



    // اشتراكات المدرس
    public function platformSubscription()
    {
        return $this->hasOne(TeacherSubscription::class);
    }

    // اشتراكات الطلاب
    public function courseSubscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
