@extends('front.layouts.front', ['title' => $title ?? 'الدعم الفني'])

@section('content')
@php
    $contactEmail = setting('contact_email') ?? 'support@fahim.com';
    $phone = setting('phone') ?? '01000000000';
@endphp
<div class="info-page">
  <div class="info-page-hero">
    <div class="hero-inner">
      <div class="hero-tag">نحن هنا لمساعدتك</div>
      <h1>الدعم الفني</h1>
      <p class="hero-desc">فريقنا متاح دايماً عشان يساعدك. تواصل معنا بالطريقة اللي تناسبك.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 60L1440 60L1440 0C1200 50 900 60 720 40C540 20 240 0 0 30Z" fill="#f0f4ff"/>
    </svg>
  </div>

  <div class="support-body">
    <div class="contact-grid">
      <a href="#" class="contact-card">
        <div class="cc-icon-wrap" style="background:#eff6ff;box-shadow:0 4px 14px rgba(26,86,219,.12)">💬</div>
        <div class="cc-title">المحادثة الفورية</div>
        <div class="cc-desc">تكلم مع فريق الدعم مباشرة وهتلاقي رد في دقائق معدودة.</div>
        <div class="cc-link">ابدأ المحادثة</div>
        <div class="cc-badge">متاح الآن</div>
      </a>
      <a href="mailto:{{ $contactEmail }}" class="contact-card">
        <div class="cc-icon-wrap" style="background:#f0fdf4;box-shadow:0 4px 14px rgba(5,150,105,.1)">📧</div>
        <div class="cc-title">البريد الإلكتروني</div>
        <div class="cc-desc">ابعت لنا تفاصيل مشكلتك وهنرد عليك خلال 24 ساعة.</div>
        <div class="cc-link">{{ $contactEmail }}</div>
        <div class="cc-badge">رد خلال 24 ساعة</div>
      </a>
      <a href="tel:{{ $phone }}" class="contact-card">
        <div class="cc-icon-wrap" style="background:#fff7ed;box-shadow:0 4px 14px rgba(234,88,12,.1)">📞</div>
        <div class="cc-title">الهاتف</div>
        <div class="cc-desc">تكلمنا مباشرة من الأحد للخميس من 9 صباحاً لـ 9 مساءً.</div>
        <div class="cc-link">{{ $phone }}</div>
        <div class="cc-badge">أحد - خميس</div>
      </a>
    </div>

    <div class="support-grid">
      <div class="support-form">
        <h3>ابعت لنا رسالة</h3>
        <p class="sf-sub">وصف مشكلتك بالتفصيل وهنتواصل معاك في أقرب وقت.</p>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @else
          <form method="POST" action="{{ route('front.contact.store') }}">
            @csrf
            <div class="field">
              <label>الاسم الكامل</label>
              <input type="text" name="name" placeholder="اسمك الكامل" value="{{ old('name') }}" required>
            </div>
            <div class="field">
              <label>البريد الإلكتروني</label>
              <input type="email" name="email" placeholder="بريدك الإلكتروني" value="{{ old('email') }}">
            </div>
            <div class="field">
              <label>رقم الهاتف</label>
              <input type="tel" name="phone" placeholder="01XXXXXXXXX" value="{{ old('phone') }}">
            </div>
            <div class="field">
              <label>نوع المشكلة</label>
              <select name="problem_type" id="support-problem-type">
                <option value="">اختر نوع المشكلة</option>
                <option value="تسجيل الدخول">مشكلة في تسجيل الدخول</option>
                <option value="الدفع">مشكلة في الدفع</option>
                <option value="الفيديو">مشكلة في تشغيل الفيديو</option>
                <option value="كورس">استفسار عن كورس</option>
                <option value="استرداد">طلب استرداد</option>
                <option value="أخرى">أخرى</option>
              </select>
            </div>
            <div class="field">
              <label>تفاصيل المشكلة</label>
              <textarea name="message" id="support-message" placeholder="اشرح مشكلتك بالتفصيل هنا..." required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn-send">إرسال الرسالة</button>
          </form>
          <script>
            document.querySelector('form[action="{{ route('front.contact.store') }}"]')?.addEventListener('submit', function(){
              var sel = document.getElementById('support-problem-type');
              var msg = document.getElementById('support-message');
              if (sel && msg && sel.value && msg.value.indexOf('[نوع:') !== 0) {
                msg.value = '[نوع: ' + sel.options[sel.selectedIndex].text + ']\n' + msg.value;
              }
            });
          </script>
        @endif
      </div>

      <div class="support-sidebar">
        <div class="sidebar-card">
          <h4><span class="icon">⚡</span> روابط سريعة</h4>
          <div class="quick-links">
            <a href="{{ route('front.page.faq') }}" class="quick-link"><span>الأسئلة الشائعة</span><span class="arr">←</span></a>
            <a href="{{ route('front.page.privacy') }}" class="quick-link"><span>سياسة الخصوصية</span><span class="arr">←</span></a>
            <a href="{{ route('front.page.terms') }}" class="quick-link"><span>الشروط والأحكام</span><span class="arr">←</span></a>
          </div>
        </div>
        <div class="sidebar-card">
          <h4><span class="icon">🕐</span> أوقات العمل</h4>
          <div class="working-hours">
            <div class="wh-row today"><span class="day">الأحد — الخميس</span><span class="time">9ص – 9م</span></div>
            <div class="wh-row"><span class="day">الجمعة</span><span class="time">2م – 8م</span></div>
            <div class="wh-row"><span class="day">السبت</span><span class="time">10ص – 6م</span></div>
          </div>
          <div class="status-badge">
            <div class="status-dot"></div>
            فريق الدعم متاح الآن
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
