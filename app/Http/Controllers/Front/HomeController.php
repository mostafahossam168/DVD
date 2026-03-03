<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = CourseReview::active()->orderBy('created_at', 'desc')->limit(12)->get();
        return view('front.home', compact('reviews'));
    }
}
