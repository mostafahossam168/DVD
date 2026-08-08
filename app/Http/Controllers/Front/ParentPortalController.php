<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\LectureProgress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    public function dashboard()
    {
        $parent = Auth::user();

        if (! $parent || $parent->type !== 'parent') {
            return redirect()->route('front.login');
        }

        $children = $parent->children()->orderBy('f_name')->get();

        return view('front.parent.dashboard', [
            'parent' => $parent,
            'children' => $children,
        ]);
    }

    public function child(User $student)
    {
        $parent = Auth::user();

        if (! $parent || $parent->type !== 'parent') {
            return redirect()->route('front.login');
        }

        abort_unless($parent->children()->where('users.id', $student->id)->exists(), 403);

        $subjects = $student->courseSubscriptions()->active()->with('subject')->get()->pluck('subject')->filter();

        $assessmentResults = AssessmentResult::where('user_id', $student->id)
            ->with('assessment.subject')
            ->latest('submitted_at')
            ->get();

        $lectureProgress = LectureProgress::where('user_id', $student->id)
            ->with('lecture.subject')
            ->latest('last_watched_at')
            ->get();

        return view('front.parent.child', [
            'parent' => $parent,
            'student' => $student,
            'subjects' => $subjects,
            'assessmentResults' => $assessmentResults,
            'lectureProgress' => $lectureProgress,
        ]);
    }
}
