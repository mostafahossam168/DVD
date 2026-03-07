<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use App\Models\Stage;
use App\Models\Subject;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.home');
    }

    /** الصفحة الرئيسية بالتصميم القديم (للاعادة عند الحاجة) */
    public function indexOld()
    {
        $reviews = CourseReview::active()->orderBy('created_at', 'desc')->limit(3)->get();
        $stages = Stage::active()
            ->with(['grades' => fn ($q) => $q->active()->withCount('subjects')])
            ->orderBy('name')
            ->get();
        $subjects = Subject::active()->with('grade')->orderBy('name')->take(12)->get();
        $featuredSubjects = Subject::active()->with('grade.stage')->take(3)->get();

        return view('front.home-old', compact('reviews', 'stages', 'subjects', 'featuredSubjects'));
    }
}
