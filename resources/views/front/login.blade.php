@extends('front.layouts.front', ['title' => 'الرئيسيه'])
@section('content')
    <section class="login-page">
        <div class="container">
            <h2 class="page-title">
                👋 أهلاً بيك، سجل دخولك وابدأ التعلّم
            </h2>

            <div class="login-card">
                <div class="row g-0">



                    <!-- Form -->
                    <div class="col-lg-6">
                        <div class="login-form">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('front.login.submit') }}" method="POST">
                                @csrf

                                <div class="login-tabs">
                                    <button type="button" class="active">بريد إلكتروني / هاتف</button>
                                </div>

                                <input type="text" name="login" value="{{ old('login') }}" class="form-control"
                                    placeholder="أدخل البريد الإلكتروني أو رقم الهاتف"
                                    style="direction: ltr; text-align: right;">
                                @error('login')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                <a href="#" class="forget-link">هل نسيت كلمة المرور؟</a>

                                <button type="submit" class="login-btn">تسجيل الدخول</button>
                            </form>

                            <p class="or-text">أو</p>

                            <div class="social-login">
                                <button class="social-btn google">
                                    <i class="fab fa-google"></i>
                                </button>

                                <button class="social-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                            </div>


                            <p class="register-text">
                                ليس لديك حساب؟
                                <a href="{{ route('front.register') }}">أنشئ حساب جديد</a>
                            </p>

                        </div>
                    </div>
                    <!-- Image -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644" class="login-image"
                            alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
