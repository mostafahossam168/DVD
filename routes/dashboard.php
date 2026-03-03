<?php

use App\Models\Grade;
use App\Models\Lecture;
use App\Models\Stage;
use App\Models\Subject;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\GradeController;
use App\Http\Controllers\Dashboard\QuizeController;
use App\Http\Controllers\Dashboard\StageController;
use App\Http\Controllers\Dashboard\LectuerController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\MaterialController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\TeacherSubscriptionController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\OnlineMeetingController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\PageContentController;
use App\Http\Controllers\Dashboard\QuizResultController;
use App\Http\Controllers\Dashboard\PaymentMethodController;
use App\Http\Controllers\Dashboard\CourseReviewController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'submitLogin'])->name('login-submit');
Route::group(['middleware' => ['auth', 'dashboard.access']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::view('settings', 'dashboard.settings')->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('update-settings');
    // Static front pages content
    Route::get('pages/{page}', [PageContentController::class, 'edit'])->name('pages.edit');
    Route::post('pages/{page}', [PageContentController::class, 'update'])->name('pages.update');
    Route::resource('/admins', AdminController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('stages', StageController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('lectuers', LectuerController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('quizes', QuizeController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('subscriptions-pending', [SubscriptionController::class, 'pending'])->name('subscriptions-pending');
    Route::post('subscriptions/{subscription}/approve', [SubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::post('subscriptions/{subscription}/reject', [SubscriptionController::class, 'reject'])->name('subscriptions.reject');
    Route::resource('teacher-subscriptions', TeacherSubscriptionController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('online-meetings', OnlineMeetingController::class);
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::resource('quiz-results', QuizResultController::class)->only(['index', 'show']);
    Route::resource('payment-methods', PaymentMethodController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('course-reviews', CourseReviewController::class);

    Route::get('get-grades/{id}', function ($id) {
        $classes = Grade::where('stage_id', $id)->get()->pluck('id', 'name');
        return json_encode($classes);
    })->name('getgrade');
    Route::get('get-subjects/{id}', function ($id) {
        $classes = Subject::where('grade_id', $id)->get()->pluck('id', 'name');
        return json_encode($classes);
    })->name('getsubjects');
    Route::get('get-lectures/{id}', function ($id) {
        $lectures = Lecture::where('subject_id', $id)->get()->pluck('id', 'title');
        return json_encode($lectures);
    })->name('getlectures');
});
