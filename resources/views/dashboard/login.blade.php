<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول</title>
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/normalize.css') }}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.rtl.min.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/all.min.css') }}" />
    <!-- Main File Css  -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/main.css') }}" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>


<body>
    <!-- Start layout -->
    <section class="login_page">
        <div class="box-col d-flex flex-column justify-content-center py-xl-0">
            <!-- Put The Messages Here Start -->
            <x-alert-component></x-alert-component>
            <!-- Put The Messages Here End -->

            <form action="{{ route('dashboard.login-submit') }}" method="POST" class="form_content">
                @csrf
                <img src="{{ asset('dashboard/img/login/logo-form.svg') }}" alt="logo" class="logo-form" />
                <h3 class="header_title">
                    <div class="title">مرحبا بك</div>
                    <div class="text">أدخل البريد الالكتروني وكلمة السر للدخول</div>
                </h3>
                <div class="row gap-3 ">
                    <div class="col-12 ">
                        <label for="" class="label">البريد الالكتروني</label>
                        <div class="group-inp">
                            <input type="email" placeholder="name@company.com" name="email" id=""
                                value="{{ old('email') }}" class="inp">
                            <div class="box">
                                <img src="{{ asset('dashboard/img/sms.svg') }}" class="icon" alt="">
                            </div>
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb-4">
                        <label for="" class="label">كلمة السر</label>
                        <div class="group-inp">
                            <input type="password" placeholder="أدخل كلمة المرور" name="password" id=""
                                class="inp">
                            <div class="box">
                                <img src="{{ asset('dashboard/img/login/eye.svg') }}" class="icon" alt="">
                            </div>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-12 mb-4 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" name="remember" value="1" id="">
                            تذكرني دائما
                        </div>
                        <a href="#" class="reseat">نسيت كلمة المرور؟</a>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="sub_btn btn btn-primary w-100">دخول</button>
                    </div>
                </div>
            </form>
        </div>
        <div
            class="box-col box-bg d-flex flex-column justify-content-between align-items-center gap-5 align-items-xl-start">
            <img src="{{ asset('dashboard/img/login/login-bg.svg') }}" alt="img-bg" class="bg" />
            <img src="{{ asset('dashboard/img/login/logo-bg.svg') }}" alt="logo" class="logo-bg" />
            <div class="text-bg">
                <div class="title">
                    إيثاق
                </div>
                <div class="p">
                    خدمات مميزة وتجربة جديدة
                </div>
            </div>
            <div class="text-bg-2">
                شركة سعودية
            </div>
        </div>
    </section>
    <!-- End layout -->
    <!-- Js Files -->
    <script src="{{ asset('dashboard/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
</body>

</html>
