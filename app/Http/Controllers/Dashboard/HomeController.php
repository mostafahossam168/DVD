<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;

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

        return view('dashboard.home', compact(
            'isTeacher',
            'teacherSubjectsCount',
            'teacherLecturesCount',
            'teacherStudentsCount'
        ));
    }
}
