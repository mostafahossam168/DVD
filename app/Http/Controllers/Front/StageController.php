<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::active()
            ->with(['grades' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        return view('front.stages.index', compact('stages'));
    }

    public function show(Stage $stage)
    {
        abort_unless($stage->status, 404);

        $stage->load(['grades' => fn ($q) => $q->active()->withCount(['subjects' => fn ($q) => $q->where('status', true)])]);

        return view('front.stages.show', compact('stage'));
    }

    public function showGrade(Grade $grade)
    {
        abort_unless($grade->status, 404);

        $grade->load(['stage', 'subjects' => fn ($q) => $q->active()]);

        $subscribedSubjectIds = [];
        $favoriteSubjectIds = [];
        if (Auth::check() && Auth::user()->type === 'student') {
            $user = Auth::user();
            $subscribedSubjectIds = $user->courseSubscriptions()
                ->active()
                ->pluck('subject_id')
                ->all();
            $favoriteSubjectIds = $user->favorites()->pluck('subject_id')->all();
        }

        return view('front.grades.show', [
            'grade' => $grade,
            'subscribedSubjectIds' => $subscribedSubjectIds,
            'favoriteSubjectIds' => $favoriteSubjectIds,
        ]);
    }
}
