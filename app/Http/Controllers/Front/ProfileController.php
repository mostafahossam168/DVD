<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $coursesCount = $user->courseSubscriptions()->active()->count();
        $ratingAvg = CourseReview::where('user_id', $user->id)->avg('rating');
        $ratingAvg = $ratingAvg !== null ? round((float) $ratingAvg, 1) : null;

        return view('front.profile.show', [
            'user' => $user,
            'coursesCount' => $coursesCount,
            'ratingAvg' => $ratingAvg,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $rules = [
            'f_name' => 'required|string|min:2|max:255',
            'l_name' => 'required|string|min:2|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'password' => ['nullable', 'string', Password::min(6)],
            'password_confirmation' => 'nullable|same:password',
            'current_password' => 'nullable|required_with:password',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        $data = $request->validate($rules);

        if (! empty($data['password'])) {
            if (! Hash::check($data['current_password'], $user->password)) {
                return redirect()->back()->withInput($request->except('password', 'password_confirmation', 'current_password'))
                    ->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
            }
        }

        $user->f_name = $data['f_name'];
        $user->l_name = $data['l_name'];
        $user->phone = $data['phone'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                delete_file($user->image);
            }
            $user->image = store_file($request->file('image'), 'profile');
        }

        $user->save();

        return redirect()->route('front.profile.show')->with('success', 'تم تحديث بياناتك بنجاح.');
    }
}

