<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        return view('front.profile.show', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $data = $request->validate([
            'f_name' => 'required|string|min:2|max:255',
            'l_name' => 'required|string|min:2|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

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

