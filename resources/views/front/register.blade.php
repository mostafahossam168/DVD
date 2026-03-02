@extends('front.layouts.front', ['title' => 'انشاء حساب جديد'])
@section('content')
    <section class="login-page">
        <div class="container">
            <h2 class="page-title text-center mb-4">
                أهلًا بيك 👋 مستقبلك يبدأ من هنا… أنشئ حسابك
            </h2>

            <div class="login-card">
                <div class="row g-0 align-items-center">

                    <!-- Form -->
                    <div class="col-lg-6">
                        <div class="login-form">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <h4 class="text-center mb-4 fw-bold">إنشاء حساب جديد</h4>

                            <form action="{{ route('front.register.submit') }}" method="POST">
                                @csrf

                                <!-- First & Last Name -->
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="f_name" class="form-control"
                                            value="{{ old('f_name') }}" placeholder="الاسم الأول">
                                        @error('f_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="l_name" class="form-control"
                                            value="{{ old('l_name') }}" placeholder="اسم العائلة">
                                        @error('l_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="البريد الإلكتروني"
                                    style="direction: ltr; text-align: right;">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                <!-- Phone -->
                                <input type="tel" name="phone" class="form-control"
                                    value="{{ old('phone') }}" placeholder="رقم الهاتف"
                                    style="direction: ltr; text-align: right;">
                                @error('phone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                <!-- Password -->
                                <div class="password-wrapper position-relative">
                                    <input type="password" id="password" name="password" class="form-control pe-5"
                                        placeholder="إنشاء كلمة المرور">
                                    <i class="fa fa-eye toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                        onclick="togglePassword()"></i>
                                </div>
                                @error('password')
                                    <span class="text-danger small d-block">{{ $message }}</span>
                                @enderror

                                <!-- Register Button -->
                                <button type="submit" class="login-btn">إنشاء حساب</button>
                            </form>

                            <!-- Login Link -->
                            <p class="register-text text-center mt-3">
                                هل لديك حساب؟
                            </p>
                            <a href="{{ route('front.login') }}" class="text-center d-block fw-bold">تسجيل الدخول</a>

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
