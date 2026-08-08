<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('front.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $data['login'];
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        foreach (['student', 'parent'] as $type) {
            $credentials = [
                $field => $login,
                'password' => $data['password'],
                'type' => $type,
            ];

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                $redirect = $type === 'parent' ? route('front.parent.dashboard') : route('front.home');

                return redirect()->intended($redirect);
            }
        }

        return back()
            ->withErrors(['login' => 'بيانات تسجيل الدخول غير صحيحة'])
            ->withInput();
    }

    public function showRegisterForm()
    {
        return view('front.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'f_name' => 'required|string|min:3|max:255',
            'l_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'type' => 'student',
            'status' => true,
        ]);

        Auth::login($user);

        return redirect()->route('front.home')->with('success', 'تم إنشاء الحساب وتسجيل الدخول بنجاح');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.login');
    }
}

