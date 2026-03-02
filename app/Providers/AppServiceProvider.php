<?php

namespace App\Providers;

use App\Models\Stage;
use App\Models\Subject;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('front.layouts.navbar', function ($view) {
            $view->with([
                'navbarStages' => Stage::active()->orderBy('name')->take(5)->get(),
                'navbarStagesCount' => Stage::active()->count(),
                'navbarSubjects' => Subject::active()->with('grade')->orderBy('name')->take(5)->get(),
                'navbarSubjectsCount' => Subject::active()->count(),
            ]);
        });
    }
}
