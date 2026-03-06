<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function privacy()
    {
        return view('front.pages.privacy', ['title' => 'سياسة الخصوصية']);
    }

    public function terms()
    {
        return view('front.pages.terms', ['title' => 'الشروط والأحكام']);
    }

    public function usagePolicy()
    {
        return view('front.pages.usage', ['title' => 'سياسة الاستخدام']);
    }

    public function about()
    {
        return view('front.pages.about', ['title' => 'عن المنصة']);
    }

    public function vision()
    {
        return view('front.pages.vision', ['title' => 'رؤيتنا']);
    }

    public function team()
    {
        return view('front.pages.team', ['title' => 'فريق العمل']);
    }

    public function faq()
    {
        return view('front.pages.faq', ['title' => 'الأسئلة الشائعة']);
    }

    public function support()
    {
        return view('front.pages.support', ['title' => 'الدعم الفني']);
    }
}
