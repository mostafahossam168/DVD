<?php

use App\Models\Grade;
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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'submitLogin'])->name('login-submit');
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::view('settings', 'dashboard.settings')->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('update-settings');
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

    Route::get('get-grades/{id}', function ($id) {
        $classes = Grade::where('stage_id', $id)->get()->pluck('id', 'name');
        return json_encode($classes);
    })->name('getgrade');
    Route::get('get-subjects/{id}', function ($id) {
        $classes = Subject::where('grade_id', $id)->get()->pluck('id', 'name');
        return json_encode($classes);
    })->name('getsubjects');
});
