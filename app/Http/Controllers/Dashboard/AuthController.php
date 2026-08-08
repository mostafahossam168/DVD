<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Http\Requests\Dashboard\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('dashboard.login');
    }


    public function submitLogin(LoginRequest $request)
    {
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

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
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
