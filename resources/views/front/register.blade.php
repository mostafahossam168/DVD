@extends('front.layouts.front', ['title' => 'إنشاء حساب جديد'])

@section('content')
<section class="auth-page auth-register">
  <div class="auth-inner">

    <!-- Visual side -->
    <div class="auth-visual">
      <div class="auth-img-card">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80" alt="طلاب يتعلمون">
        <div class="auth-img-overlay">
          <div class="auth-img-tag">🚀 ابدأ رحلتك الآن</div>
          <p>آلاف الطلاب بدأوا رحلتهم معنا وحققوا أهدافهم</p>
        </div>
        <div class="auth-stat-badge top">
          <span class="icon">👥</span>
          <div class="info">
            <span class="num">50K+</span>
            <span class="lbl">طالب نشط</span>
          </div>
        </div>
        <div class="auth-stat-badge bottom">
          <span class="icon">🏆</span>
          <div class="info">
            <span class="num">98%</span>
            <span class="lbl">نسبة الرضا</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Form side -->
    <div class="auth-form-side">
      <div class="auth-form-card">
        <h1 class="auth-title">إنشاء حساب جديد</h1>
        <p class="auth-subtitle">انضم إلينا وابدأ رحلتك التعليمية اليوم</p>

        @if ($errors->any())
          <div class="auth-errors">
            <div class="alert alert-danger mb-2">
              {{ $errors->first() }}
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('front.register.submit') }}">
          @csrf

          <div class="auth-field-row">
            <div class="auth-field">
              <label>الاسم الأول</label>
              <div class="auth-input-wrap">
                <input
                  type="text"
                  name="f_name"
                  value="{{ old('f_name') }}"
                  placeholder="الاسم الأول">
              </div>
              @error('f_name')
                <span class="text-danger small d-block mt-1">{{ $message }}</span>
              @enderror
            </div>
            <div class="auth-field">
              <label>اسم العائلة</label>
              <div class="auth-input-wrap">
                <input
                  type="text"
                  name="l_name"
                  value="{{ old('l_name') }}"
                  placeholder="اسم العائلة">
              </div>
              @error('l_name')
                <span class="text-danger small d-block mt-1">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="auth-field">
            <label>البريد الإلكتروني</label>
            <div class="auth-input-wrap">
              <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="أدخل بريدك الإلكتروني"
                style="direction:ltr;text-align:right">
              <span class="auth-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
              </span>
            </div>
            @error('email')
              <span class="text-danger small d-block mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="auth-field">
            <label>رقم الهاتف</label>
            <div class="auth-input-wrap">
              <input
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="أدخل رقم هاتفك"
                style="direction:ltr;text-align:right">
              <span class="auth-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.16 6.16l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
              </span>
            </div>
            @error('phone')
              <span class="text-danger small d-block mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="auth-field">
            <label>كلمة المرور</label>
            <div class="auth-input-wrap">
              <input
                type="password"
                id="register-password"
                name="password"
                placeholder="أنشئ كلمة مرور قوية">
              <span class="auth-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <button type="button" class="auth-input-eye" onclick="toggleAuthPass('register-password', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                </svg>
              </button>
            </div>
            @error('password')
              <span class="text-danger small d-block mt-1">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit" class="auth-btn-submit">
            إنشاء الحساب
          </button>

          <div class="auth-footer">
            هل لديك حساب بالفعل؟
            <a href="{{ route('front.login') }}">تسجيل الدخول</a>
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

