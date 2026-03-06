@extends('front.layouts.front', ['title' => 'فاهم — تواصل معنا'])

@section('content')
@php
    $contactEmail = setting('contact_email') ?? setting('website_url');
    if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
        $contactEmail = 'support@fahem.com';
    }
    $phone = setting('phone') ?? '';
    $whatsapp = setting('whatsapp') ?? $phone;
    $whatsappLink = $whatsapp ? 'https://wa.me/2' . preg_replace('/\D/', '', $whatsapp) : '#';
    $facebook = setting('facebook') ?? '#';
    $instagram = setting('instagram') ?? '#';
@endphp

{{-- Hero --}}
<div class="hero-band">
    <div class="hero-inner">
        <div class="hero-eyebrow">💬 تواصل معنا</div>
        <h1>نحن هنا <em>لمساعدتك</em></h1>
        <p>يمكنك التواصل معنا في أي وقت من خلال بيانات الاتصال التالية أو من خلال نموذج التواصل.</p>
    </div>
</div>

{{-- Contact Section --}}
<div class="contact-section">
    {{-- Info Panel --}}
    <div class="info-panel">
        <div>
            <div class="info-headline">كيف يمكننا<br/>مساعدتك؟</div>
            <div class="info-sub">فريقنا متاح للإجابة على أسئلتك ومساعدتك في أي شيء يتعلق بالمنصة أو الكورسات.</div>
            <div class="response-badge">
                <div class="dot-live"></div>
                نرد عادةً خلال ساعة
            </div>
        </div>

        <div class="contact-cards">
            <a href="mailto:{{ $contactEmail }}" class="contact-card">
                <div class="contact-card-icon icon-email">✉️</div>
                <div class="contact-card-text">
                    <div class="contact-card-label">البريد الإلكتروني</div>
                    <div class="contact-card-value link">{{ $contactEmail }}</div>
                </div>
            </a>

            @if($phone)
            <a href="tel:{{ $phone }}" class="contact-card">
                <div class="contact-card-icon icon-phone">📞</div>
                <div class="contact-card-text">
                    <div class="contact-card-label">رقم الهاتف</div>
                    <div class="contact-card-value">{{ $phone }}</div>
                </div>
            </a>
            @endif

            @if($whatsapp)
            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="contact-card">
                <div class="contact-card-icon icon-whatsapp">💬</div>
                <div class="contact-card-text">
                    <div class="contact-card-label">واتساب</div>
                    <div class="contact-card-value link">تحدث معنا على واتساب</div>
                </div>
            </a>
            @endif

            @if($facebook)
            <a href="{{ $facebook }}" target="_blank" rel="noopener" class="contact-card">
                <div class="contact-card-icon icon-facebook">📘</div>
                <div class="contact-card-text">
                    <div class="contact-card-label">فيسبوك</div>
                    <div class="contact-card-value link">facebook.com/fahem</div>
                </div>
            </a>
            @endif

            @if($instagram)
            <a href="{{ $instagram }}" target="_blank" rel="noopener" class="contact-card">
                <div class="contact-card-icon icon-instagram">📸</div>
                <div class="contact-card-text">
                    <div class="contact-card-label">إنستاجرام</div>
                    <div class="contact-card-value link">@fahem.eg</div>
                </div>
            </a>
            @endif
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="form-panel">
        @if(session('success'))
            <div class="success-msg show" id="successMsg">
                <div class="success-icon">✅</div>
                <div class="success-title">تم إرسال رسالتك بنجاح!</div>
                <div class="success-text">{{ session('success') }}</div>
                <a href="{{ route('front.contact') }}" class="btn-primary" style="margin:24px auto 0; display:inline-block; padding:10px 28px; text-decoration:none;">إرسال رسالة أخرى</a>
            </div>
        @else
            <div id="formContent">
                <div class="form-panel-title">✍️ أرسل لنا رسالة</div>
                <div class="form-panel-sub">املأ النموذج التالي وسيتواصل معك فريقنا في أقرب وقت ممكن.</div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-divider"></div>

                <form method="POST" action="{{ route('front.contact.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact-name">الاسم الكامل <span>*</span></label>
                            <input type="text" id="contact-name" name="name" class="form-input" placeholder="مثال: أحمد محمد" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-phone">رقم التليفون</label>
                            <input type="tel" id="contact-phone" name="phone" class="form-input" placeholder="01XXXXXXXXX" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact-email">البريد الإلكتروني</label>
                        <input type="email" id="contact-email" name="email" class="form-input" placeholder="example@email.com" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact-message">الرسالة <span>*</span></label>
                        <textarea id="contact-message" name="message" class="form-input form-textarea" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>إرسال الرسالة</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform:scaleX(-1)"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
