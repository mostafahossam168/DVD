<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $subjects = $user->favoriteSubjects()
            ->active()
            ->with('grade.stage')
            ->orderBy('name')
            ->get();

        return view('front.favorites.index', compact('subjects'));
    }

    public function toggle(Subject $subject)
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول كطالب'], 401);
            }
            return redirect()->route('front.login');
        }

        abort_unless($subject->status, 404);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
            ]);
            $favorited = true;
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'favorited' => $favorited,
            ]);
        }

        return back()->with('success', $favorited ? 'تمت إضافة الكورس للمفضلة' : 'تمت إزالة الكورس من المفضلة');
    }
}
