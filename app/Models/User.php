<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Subject;
use App\Models\Subscription;
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
        'stage_id',
        'grade_id',
        'study_mode',
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
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return trim($this->f_name . ' ' . $this->l_name);
    }

    /** يعتبر المستخدم "أونلاين" لو ظهر خلال آخر 5 دقائق */
    public function isOnline(): bool
    {
        return (bool) $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }

    public function getLastSeenLabelAttribute(): string
    {
        if ($this->isOnline()) {
            return 'متصل الآن';
        }

        return $this->last_seen_at ? 'آخر ظهور ' . $this->last_seen_at->diffForHumans() : 'لم يسجل الدخول بعد';
    }

    public function scopeOnline($q)
    {
        return $q->where('last_seen_at', '>', now()->subMinutes(5));
    }

    public function scopeOffline($q)
    {
        return $q->where(function ($q) {
            $q->whereNull('last_seen_at')->orWhere('last_seen_at', '<=', now()->subMinutes(5));
        });
    }

    public function scopeAdmins($q)
    {
        return $q->where('type', 'admin');
    }
    public function scopeStudents($q)
    {
        return $q->where('type', 'student');
    }
    public function scopeParents($q)
    {
        return $q->where('type', 'parent');
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
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function stage() { return $this->belongsTo(Stage::class); }
    public function grade() { return $this->belongsTo(Grade::class); }
    public function monthlyInvoices() { return $this->hasMany(StudentMonthlyInvoice::class, 'student_id'); }



    // اشتراكات الطلاب
    public function courseSubscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // المفضلة
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteSubjects()
    {
        return $this->belongsToMany(Subject::class, 'student_favorites', 'user_id', 'subject_id');
    }

    public function onlineMeetings()
    {
        return $this->hasMany(OnlineMeeting::class, 'teacher_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'teacher_id');
    }

    public function questionBankQuestions()
    {
        return $this->hasMany(QuestionBankQuestion::class, 'teacher_id');
    }

    // أبناء ولي الأمر
    public function children()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'parent_id', 'student_id');
    }

    // أولياء أمور الطالب
    public function guardians()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }

    // تقدّم مشاهدة المحاضرات
    public function lectureProgress()
    {
        return $this->hasMany(LectureProgress::class);
    }
}
