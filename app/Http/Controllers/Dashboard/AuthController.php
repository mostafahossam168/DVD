<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('dashboard.login');
    }


    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // return auth()->user();
            return redirect()->route('dashboard.home');
        }
        return redirect()->back()->with('error',  'البريد الإلكتروني أو كلمة المرور غير صحيحة')->withInput();
    }


    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'f_name' => 'required|string|min:3|max:255',
            'l_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'image' => 'nullable|mimes:jpg,png',
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ]);
        if ($request->image) {
            $data['image'] = store_file($request->image, 'users');
            delete_file($user->image);
        }

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->back()->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('dashboard.login')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
