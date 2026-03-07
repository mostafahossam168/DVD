@extends('front.layouts.front', ['title' => 'تسجيل الدخول'])

@section('content')
<section class="auth-page auth-login">
  <div class="auth-inner">

    <!-- Visual side -->
    <div class="auth-visual">
      <div class="auth-img-card">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80" alt="طلاب يتعلمون">
        <div class="auth-img-overlay">
          <div class="auth-img-tag">🎓 منصة فاهم</div>
          <p>انضم لآلاف الطلاب اللي بيتعلموا معنا كل يوم</p>
        </div>
        <div class="auth-stat-badge top">
          <span class="icon">📚</span>
          <div class="info">
            <span class="num">+1200</span>
            <span class="lbl">كورس متاح</span>
          </div>
        </div>
        <div class="auth-stat-badge bottom">
          <span class="icon">⭐</span>
          <div class="info">
            <span class="num">4.9 / 5</span>
            <span class="lbl">تقييم الطلاب</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Form side -->
    <div class="auth-form-side">
      <div class="auth-form-card">
        <h1 class="auth-title">تسجيل الدخول</h1>
        <p class="auth-subtitle">مرحباً بعودتك! أدخل بياناتك للمتابعة</p>

        @if ($errors->any())
          <div class="auth-errors">
            <div class="alert alert-danger mb-2">
              {{ $errors->first() }}
            </div>
          </div>
        @endif
        @if (session('success'))
          <div class="auth-errors">
            <div class="alert alert-success mb-2">
              {{ session('success') }}
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('front.login.submit') }}">
          @csrf

          <div class="auth-field">
            <label>البريد الإلكتروني / الهاتف</label>
            <div class="auth-input-wrap">
              <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                placeholder="أدخل البريد الإلكتروني أو رقم الهاتف"
                style="direction:ltr;text-align:right">
              <span class="auth-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect width="20" height="16" x="2" y="4" rx="2"/>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
              </span>
            </div>
            @error('login')
              <span class="text-danger small d-block mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="auth-field">
            <label>كلمة المرور</label>
            <div class="auth-input-wrap">
              <input
                type="password"
                id="login-password"
                name="password"
                placeholder="أدخل كلمة المرور">
              <span class="auth-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <button type="button" class="auth-input-eye" onclick="toggleAuthPass('login-password', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                </svg>
              </button>
            </div>
            @error('password')
              <span class="text-danger small d-block mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="auth-forgot">
            <a href="#">هل نسيت كلمة المرور؟</a>
          </div>

          <button type="submit" class="auth-btn-submit">
            تسجيل الدخول
          </button>

          <div class="auth-divider">
            <span>أو سجّل بـ</span>
          </div>

          <div class="auth-social-btns">
            <button type="button" class="auth-social-btn">
              <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
              Google
            </button>
            <button type="button" class="auth-social-btn">
              <img src="https://www.svgrepo.com/show/448224/facebook.svg" alt="Facebook">
              Facebook
            </button>
          </div>

          <div class="auth-footer">
            ليس لديك حساب؟
            <a href="{{ route('front.register') }}">أنشئ حساب جديد</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@push('scripts')
<script>
  function toggleAuthPass(id, btn) {
    var input = document.getElementById(id);
    if (!input) return;
    if (input.type === 'password') {
      input.type = 'text';
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    } else {
      input.type = 'password';
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>';
    }
  }
</script>
@endpush
@endsection

