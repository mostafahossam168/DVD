<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاهم — تسجيل الدخول | لوحة التحكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/login.css') }}">
</head>

<body>

    @if (session('success'))
        <div class="toast show" id="toast">
            <span>✅</span>
            <span id="toast-msg">{{ session('success') }}</span>
            <button type="button" class="t-close"
                style="margin-right:auto;cursor:pointer;background:none;border:none;font-size:1.1rem;color:var(--muted)"
                onclick="document.getElementById('toast').classList.remove('show')">×</button>
        </div>
    @endif
    @if (session('error'))
        <div class="toast error show" id="toast">
            <span>⚠️</span>
            <span id="toast-msg">{{ session('error') }}</span>
            <button type="button" class="t-close"
                style="margin-right:auto;cursor:pointer;background:none;border:none;font-size:1.1rem;color:var(--muted)"
                onclick="document.getElementById('toast').classList.remove('show')">×</button>
        </div>
    @endif

    <div class="wrapper">
        <div class="left-panel">
            <div class="bg-img"></div>
            <div class="grid-pattern"></div>
            <div class="geo geo-1"></div>
            <div class="geo geo-2"></div>
            <div class="geo geo-3"></div>
            <div class="left-content">
                <div class="left-logo anim">
                    <div class="logo-box">ف</div>
                    <div class="logo-info">
                        <div class="logo-name">فاهم</div>
                        <div class="logo-sub">لوحة التحكم</div>
                    </div>
                </div>
                <div class="left-hero">
                    <div class="hero-badge anim d1">
                        <div class="dot"></div>
                        النظام يعمل بكفاءة كاملة
                    </div>
                    <h1 class="hero-title anim d2">منصة<br><span>فاهم</span></h1>
                    <p class="hero-desc anim d2">
                        بيئة إدارية متكاملة لإدارة المحتوى التعليمي والطلاب بكل سهولة واحترافية.
                    </p>
                </div>
                <div class="left-stats anim d3">
                    <div class="lstat">
                        <div class="n">50K+</div>
                        <div class="l">طالب مسجل</div>
                    </div>
                    <div class="lstat">
                        <div class="n">+1200</div>
                        <div class="l">كورس متاح</div>
                    </div>
                    <div class="lstat">
                        <div class="n">4.9★</div>
                        <div class="l">تقييم المنصة</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="panel-tag">
                <div class="tag-dot"></div>
                نظام آمن ومشفّر
            </div>

            <form action="{{ route('dashboard.login-submit') }}" method="POST" class="login-card anim d1"
                id="loginForm">
                @csrf
                <div class="card-head">
                    <div class="card-avatar">🛡️</div>
                    <h2>مرحباً بك</h2>
                    <p>أدخل بياناتك للوصول إلى لوحة التحكم</p>
                    <div class="role-label admin">مدير النظام — Admin</div>
                </div>

                <div class="field">
                    <label>البريد الإلكتروني</label>
                    <div class="input-wrap">
                        <input type="email" name="email" id="emailInput" placeholder="admin@fahim.com"
                            value="{{ old('email') }}" required autocomplete="email">
                        <span class="i-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </span>
                    </div>
                    @error('email')
                        <div class="err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>
                        كلمة المرور
                        <a href="#">نسيت كلمة المرور؟</a>
                    </label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="passInput" placeholder="أدخل كلمة المرور" required
                            autocomplete="current-password">
                        <span class="i-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="11" x="3" y="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <button type="button" class="i-left" id="eyeBtn" onclick="togglePass()"
                            aria-label="إظهار كلمة المرور">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        <span>تذكّرني دائماً</span>
                    </label>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    <span>دخول</span>
                </button>

                <div class="security-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    الاتصال مشفّر — بياناتك آمنة
                </div>
            </form>
        </div>
    </div>

    <script>
        var passVisible = false;

        function togglePass() {
            passVisible = !passVisible;
            var inp = document.getElementById('passInput');
            inp.type = passVisible ? 'text' : 'password';
            var icon = document.getElementById('eyeIcon');
            if (passVisible) {
                icon.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            var btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> جاري التحقق...';
        });
    </script>
</body>

</html>
