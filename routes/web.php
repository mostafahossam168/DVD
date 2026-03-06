<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AuthController as FrontAuthController;
use App\Http\Controllers\Front\ContactController as FrontContactController;
use App\Http\Controllers\Front\PageController as FrontPageController;
use App\Http\Controllers\Front\CourseController as FrontCourseController;
use App\Http\Controllers\Front\QuizController as FrontQuizController;
use App\Http\Controllers\Front\ProfileController as FrontProfileController;
use App\Http\Controllers\Front\StageController as FrontStageController;
use App\Http\Controllers\Front\FavoriteController as FrontFavoriteController;

// Front site

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/login', [FrontAuthController::class, 'showLoginForm'])->name('front.login');
Route::post('/login', [FrontAuthController::class, 'login'])->name('front.login.submit');
Route::get('/register', [FrontAuthController::class, 'showRegisterForm'])->name('front.register');
Route::post('/register', [FrontAuthController::class, 'register'])->name('front.register.submit');
Route::post('/logout', [FrontAuthController::class, 'logout'])->name('front.logout');
// Student profile & favorites
Route::middleware('auth')->group(function () {
    Route::get('/profile', [FrontProfileController::class, 'show'])->name('front.profile.show');
    Route::post('/profile', [FrontProfileController::class, 'update'])->name('front.profile.update');
    Route::get('/my-favorites', [FrontFavoriteController::class, 'index'])->name('front.favorites.index');
    Route::post('/courses/{subject}/favorite', [FrontFavoriteController::class, 'toggle'])->name('front.favorites.toggle');
});

Route::get('/contact', function () {
    return view('front.contact');
})->name('front.contact');

Route::post('/contact', [FrontContactController::class, 'store'])->name('front.contact.store');

Route::get('/stages', [FrontStageController::class, 'index'])->name('front.stages.index');
Route::get('/stages/{stage}', [FrontStageController::class, 'show'])->name('front.stages.show');
Route::get('/grades/{grade}', [FrontStageController::class, 'showGrade'])->name('front.grades.show');

Route::get('/subjects', function () {
    $subjects = \App\Models\Subject::active()->with('grade.stage')->orderBy('name')->get();
    $favoriteSubjectIds = [];
    if (auth()->check() && auth()->user()->type === 'student') {
        $favoriteSubjectIds = auth()->user()->favorites()->pluck('subject_id')->all();
    }
    return view('front.subjects', compact('subjects', 'favoriteSubjectIds'));
})->name('front.subjects.index');

// الصفحات الثابتة
Route::get('/privacy', [FrontPageController::class, 'privacy'])->name('front.page.privacy');
Route::get('/terms', [FrontPageController::class, 'terms'])->name('front.page.terms');
Route::get('/usage-policy', [FrontPageController::class, 'usagePolicy'])->name('front.page.usage');
Route::get('/about', [FrontPageController::class, 'about'])->name('front.page.about');
Route::get('/vision', [FrontPageController::class, 'vision'])->name('front.page.vision');
Route::get('/team', [FrontPageController::class, 'team'])->name('front.page.team');
Route::get('/faq', [FrontPageController::class, 'faq'])->name('front.page.faq');
Route::get('/support', [FrontPageController::class, 'support'])->name('front.page.support');

// Vodafone Cash info page
Route::get('/vodafone-cash', function () {
    return view('front.pages.vodafone-cash');
})->name('front.page.vodafone');

// Courses & lessons (student front)
Route::get('/courses', [FrontCourseController::class, 'index'])->name('front.courses.index');
Route::get('/my-courses', [FrontCourseController::class, 'myCourses'])->name('front.courses.my');
Route::get('/courses/{subject}', [FrontCourseController::class, 'showSubject'])->name('front.courses.subject');
Route::post('/courses/{subject}/subscribe', [FrontCourseController::class, 'subscribe'])->name('front.courses.subscribe');
Route::get('/courses/{subject}/lessons/{lecture}', [FrontCourseController::class, 'showLesson'])->name('front.courses.lesson');
Route::post('/courses/{subject}/rate', [FrontCourseController::class, 'rate'])->name('front.courses.rate');


// Quizzes
Route::get('/quizzes/{quiz}', [FrontQuizController::class, 'show'])->name('front.quizzes.show');
// Route::get('/quizzes/{quiz}', [FrontQuizController::class, 'show'])->name('front.quizzes.show');
Route::post('/quizzes/{quiz}', [FrontQuizController::class, 'submit'])->name('front.quizzes.submit');
Route::get('/my-quizzes', [FrontQuizController::class, 'history'])->name('front.quizzes.history');
Route::get('/quizzes/{quiz}/review', [FrontQuizController::class, 'review'])->name('front.quizzes.review');
