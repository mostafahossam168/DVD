<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Lecture;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        $isTeacher = auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin');

        $teacherSubjectsCount = 0;
        $teacherLecturesCount = 0;
        $teacherStudentsCount = 0;

        if ($isTeacher) {
            $teacherSubjectIds = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', auth()->id()))
                ->pluck('id');
            $teacherSubjectsCount = $teacherSubjectIds->count();
            $teacherLecturesCount = Lecture::whereIn('subject_id', $teacherSubjectIds)->count();
            $teacherStudentsCount = Subscription::active()
                ->whereIn('subject_id', $teacherSubjectIds)
                ->pluck('user_id')
                ->unique()
                ->count();
        }

        $adminsCount = User::admins()->count();
        $teachersCount = User::teachers()->count();
        $studentsCount = User::students()->count();
        $stagesCount = Stage::count();
        $subjectsCount = Subject::count();
        $lecturesCount = Lecture::count();
        $rolesCount = Role::count();
        $contactsCount = Contact::count();
        $pendingCount = Subscription::where('payment_status', 'pending')->count();
        $pendingSubscriptions = Subscription::with(['user', 'subject'])
            ->where('payment_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.home', compact(
            'isTeacher',
            'teacherSubjectsCount',
            'teacherLecturesCount',
            'teacherStudentsCount',
            'adminsCount',
            'teachersCount',
            'studentsCount',
            'stagesCount',
            'subjectsCount',
            'lecturesCount',
            'rolesCount',
            'contactsCount',
            'pendingCount',
            'pendingSubscriptions'
        ));
    }
}
