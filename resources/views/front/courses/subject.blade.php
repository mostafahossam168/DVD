@extends('front.layouts.front', ['title' => 'فاهم — ' . $subject->name])

@section('content')
@php
    $grade = $subject->grade;
    $stage = $grade?->stage;
@endphp

@if(session('success'))
    <div class="alert alert-success m-3 mx-auto" style="max-width: 1200px; margin: 1rem 5% !important;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger m-3 mx-auto" style="max-width: 1200px; margin: 1rem 5% !important;">{{ session('error') }}</div>
@endif

{{-- Breadcrumb --}}
<div class="breadcrumb-course">
    <a href="{{ route('front.courses.index') }}">الكورسات</a>
    <span class="breadcrumb-sep">/</span>
    @if($stage)
        <a href="{{ route('front.courses.index') }}">{{ $stage->name }}</a>
        <span class="breadcrumb-sep">/</span>
    @endif
    @if($grade)
        <a href="{{ route('front.courses.index') }}">{{ $grade->name }}</a>
        <span class="breadcrumb-sep">/</span>
    @endif
    <span>{{ $subject->name }}</span>
</div>

{{-- Course Hero --}}
<div class="course-hero">
    <div class="course-hero-text">
        <div class="course-hero-subject">{{ $subject->name }}</div>
        <div class="course-hero-title">{{ $subject->name }}</div>
        <div class="course-hero-meta">{{ $grade?->name ?? '' }} — {{ $stage?->name ?? '' }}</div>
        <div class="course-badges">
            <span class="course-badge">📹 فيديو مسجل</span>
            @if(($firstLectureWithQuiz ?? null) || ($lectures->contains(fn($l) => $l->has_quiz ?? false)))
                <span class="course-badge">✅ اختبارات تفاعلية</span>
            @endif
            @if(($ratingCount ?? 0) > 0)
                <span class="course-badge">⭐ {{ $ratingAvg }} تقييم</span>
                <span class="course-badge">👥 {{ $ratingCount }} تقييم</span>
            @endif
        </div>
    </div>
    <div class="course-hero-img">
        @if($subject->image)
            <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}">
        @else
            ✍️
        @endif
    </div>
    <div class="course-hero-fav">
        @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => $isFavorite ?? false])
    </div>
</div>

<div class="course-page-layout">
    {{-- LEFT COLUMN --}}
    <div>
        {{-- Lessons --}}
        @if($lectures->count() > 0)
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">📚 الدروس <span class="section-card-badge">{{ $lectures->count() }} درس</span></div>
                @if(!$hasActiveSubscription)
                    <div class="enroll-hint-badge">🔒 اشترك لمشاهدة الدروس</div>
                @endif
            </div>
            <div class="lessons-list">
                @foreach($lectures as $lecture)
                    @php
                        $canAccess = $hasActiveSubscription && $student && $lecture->status;
                    @endphp
                    @if($canAccess)
                    <a href="{{ route('front.courses.lesson', [$subject, $lecture]) }}" class="lesson-item {{ $loop->first ? 'active' : '' }}">
                        <div class="lesson-icon lesson-icon-play">▶</div>
                        <div class="lesson-info">
                            <div class="lesson-title">{{ $lecture->title }}</div>
                            <div class="lesson-desc">{{ \Illuminate\Support\Str::limit($lecture->description ?? '', 80) }}</div>
                            <div class="lesson-meta">
                                <span class="lesson-tag">📁 {{ $lecture->materials_count ?? 0 }} مواد</span>
                                @if($lecture->has_quiz ?? false)<span class="lesson-tag">📝 اختبار</span>@endif
                            </div>
                        </div>
                        <div class="lesson-action">
                            <span class="btn-lesson btn-lesson-play">▶ شاهد الآن</span>
                        </div>
                    </a>
                    @else
                    <div class="lesson-item locked" onclick="subjectPageShowLockModal()">
                        <div class="lesson-icon lesson-icon-lock">🔒</div>
                        <div class="lesson-info">
                            <div class="lesson-title">{{ $lecture->title }}</div>
                            <div class="lesson-desc">اشترك في الكورس لتتمكن من مشاهدة هذا الدرس والوصول لكل المحتوى</div>
                            <div class="lesson-meta">
                                <span class="lesson-tag">📁 {{ $lecture->materials_count ?? 0 }} مواد</span>
                                @if($lecture->has_quiz ?? false)<span class="lesson-tag">📝 اختبار</span>@endif
                            </div>
                        </div>
                        <div class="lesson-action">
                            <button type="button" class="btn-lesson btn-lesson-lock-amber" onclick="event.stopPropagation(); subjectPageScrollToEnroll();">🔒 اشترك الآن</button>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Live Sessions --}}
        @if(($onlineMeetings ?? collect())->count() > 0)
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">🔴 حصص لايف</div>
            </div>
            @foreach($onlineMeetings as $meeting)
            <div class="live-item">
                <div class="live-dot red"></div>
                <div class="live-info">
                    <div class="live-title">{{ $meeting->topic }}</div>
                    <div class="live-time">{{ $meeting->start_time?->translatedFormat('l j F Y') }} — {{ $meeting->start_time?->format('H:i') }}</div>
                </div>
                @if($hasActiveSubscription && $student && $meeting->join_url)
                    <a href="{{ $meeting->join_url }}" target="_blank" rel="noopener" class="btn-zoom">📹 دخول زوم</a>
                @else
                    <span class="btn-zoom" style="cursor:default;opacity:0.8">اشترك للدخول</span>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Resource cards --}}
        <div class="resource-grid">
            <a href="#" class="resource-card">
                <div class="resource-icon">📄</div>
                <div class="resource-title">ملخص الكورس</div>
                <div class="resource-desc">تأكد من فهمك لكل الدروس عبر مراجعة المحتوى</div>
            </a>
            @if($firstQuiz && $hasActiveSubscription && $student)
                <a href="{{ route('front.quizzes.show', $firstQuiz) }}" class="resource-card amber">
                    <div class="resource-icon">📝</div>
                    <div class="resource-title">اختبارات الدروس</div>
                    <div class="resource-desc">اختبر مستواك وفهمك لكل درس</div>
                    <div style="color:#F59E0B;font-size:0.78rem;font-weight:700;margin-top:6px">ابدأ الامتحان ←</div>
                </a>
            @else
                <div class="resource-card amber" style="cursor:default;opacity:0.9">
                    <div class="resource-icon">📝</div>
                    <div class="resource-title">اختبارات الدروس</div>
                    <div class="resource-desc">اشترك في الكورس لفتح الاختبارات</div>
                </div>
            @endif
        </div>

        {{-- Ratings & Reviews --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">⭐ تقييمات الطلاب <span class="section-card-badge">{{ $ratingCount ?? 0 }} تقييم</span></div>
            </div>

            @if(($ratingCount ?? 0) > 0)
            <div class="ratings-summary">
                <div class="rating-big-score">
                    <div class="rating-number">{{ $ratingAvg }}</div>
                    <div class="rating-stars-big">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star filled" style="color: {{ $i <= round($ratingAvg) ? '#F59E0B' : '#D1D5DB' }}">★</span>
                        @endfor
                    </div>
                    <div class="rating-count">{{ $ratingCount }} تقييم</div>
                </div>
                <div class="rating-bars">
                    @foreach($ratingBars ?? [] as $bar)
                    <div class="rating-bar-row">
                        <span class="rating-bar-label">{{ $bar['star'] }}</span>
                        <div class="rating-bar-track"><div class="rating-bar-fill" style="width:{{ $bar['pct'] }}%"></div></div>
                        <span class="rating-bar-pct">{{ $bar['pct'] }}٪</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @forelse($reviews ?? [] as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="review-user">
                        @if($review->user?->image ?? $review->image ?? null)
                            <div class="review-avatar"><img src="{{ display_file($review->user->image ?? $review->image) }}" alt=""></div>
                        @else
                            <div class="review-avatar">{{ mb_substr($review->name ?? '؟', 0, 1) }}</div>
                        @endif
                        <div>
                            <div class="review-name">{{ $review->name }}</div>
                            @if($review->user?->phone)
                                <div class="review-phone">{{ $review->user->phone }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= (int)$review->rating ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>
                </div>
                <div class="review-body">{{ $review->review_text }}</div>
            </div>
            @empty
            <div class="review-item">
                <div class="review-body text-muted">لا توجد تقييمات حتى الآن.</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="sidebar-right">
        @if(session('success') && $student && !$hasActiveSubscription)
            <div class="enroll-success-msg show">
                <div style="font-size:2.5rem;margin-bottom:12px">🎉</div>
                <div style="font-weight:900;font-size:1rem;color:var(--dark);margin-bottom:6px">تم إرسال طلب الاشتراك!</div>
                <div style="font-size:0.83rem;color:var(--muted);line-height:1.7">سيتم مراجعة طلبك وتفعيل اشتراكك خلال وقت قصير.</div>
            </div>
        @endif

        {{-- Enroll Card --}}
        <div class="enroll-card" id="enrollCard">
            <div class="enroll-card-header">
                @if($student && $hasActiveSubscription)
                    <div class="enroll-status">✅ أنت مشترك</div>
                    <div class="enroll-title">الاشتراك في الكورس</div>
                    <div class="enroll-sub">لديك وصول كامل لجميع المحتوى</div>
                @else
                    <div class="enroll-status" style="background:rgba(245,158,11,0.25);color:#FEF3C7">💳 اشترك في الكورس</div>
                    <div class="enroll-title">الاشتراك في الكورس</div>
                    <div class="enroll-sub">أكمل بيانات الاشتراك لتحصل على وصول كامل</div>
                @endif
            </div>
            <div class="enroll-body" style="padding:20px">
                @if($student && $hasActiveSubscription)
                    <a href="{{ route('front.courses.my') }}" class="btn-enroll btn-enroll-primary">الذهاب إلى كورساتي</a>
                    @if($hasRated ?? false)
                        <div class="enrolled-check">✔ تم تقييمك لهذا الكورس</div>
                    @elseif($canRate ?? false)
                        <form method="POST" action="{{ route('front.courses.rate', $subject) }}" class="mt-3">
                            @csrf
                            <label class="enroll-label">قيّم الكورس</label>
                            <select name="rating" class="enroll-select mb-2" required style="margin-bottom:12px">
                                <option value="">-- اختر --</option>
                                @for($i = 1; $i <= 5; $i++)<option value="{{ $i }}">{{ $i }} ⭐</option>@endfor
                            </select>
                            <textarea name="review_text" class="form-input form-textarea mb-2" rows="2" minlength="10" required placeholder="اكتب رأيك (10 حروف على الأقل)"></textarea>
                            <button type="submit" class="btn-enroll btn-enroll-primary">إرسال التقييم</button>
                        </form>
                    @endif
                @elseif(!$student)
                    <a href="{{ route('front.login') }}" class="btn-enroll btn-enroll-primary">تسجيل الدخول</a>
                    <a href="{{ route('front.register') }}" class="btn-enroll btn-enroll-outline">إنشاء حساب</a>
                @else
                    @if(session('success'))
                        <p class="text-muted small mb-0">تم استلام طلبك. سنراجع الدفع ونفعّل اشتراكك قريباً.</p>
                    @elseif($paymentMethods->isEmpty())
                        <p class="text-muted small mb-0">لا توجد طرق دفع مفعلة حالياً. تواصل مع الإدارة.</p>
                    @else
                        <form method="POST" action="{{ route('front.courses.subscribe', $subject) }}" enctype="multipart/form-data" id="enrollForm">
                            @csrf
                            <input type="hidden" name="payment_method" id="paymentMethodInput" value="">
                            <div class="form-group-enroll">
                                <label class="enroll-label">نوع الاشتراك <span style="color:#EF4444">*</span></label>
                                <div class="custom-select-wrap">
                                    <select name="period_type" id="subType" class="enroll-select" onchange="subjectPageHandleSubType()" required>
                                        <option value="">-- اختر نوع الاشتراك --</option>
                                        <option value="term">ترم دراسي (افتراضي)</option>
                                        <option value="month">شهر</option>
                                    </select>
                                    <span class="select-arrow">▼</span>
                                </div>
                            </div>
                            <div class="form-group-enroll" id="termNumberWrapper" style="display:none">
                                <label class="enroll-label">رقم الترم <span style="color:#EF4444">*</span></label>
                                <div class="custom-select-wrap">
                                    <select name="term_number" id="termNum" class="enroll-select">
                                        <option value="">-- اختر الترم --</option>
                                        <option value="1">الأول</option>
                                        <option value="2">الثاني</option>
                                        <option value="3">الثالث</option>
                                    </select>
                                    <span class="select-arrow">▼</span>
                                </div>
                            </div>
                            <div class="form-group-enroll">
                                <label class="enroll-label">طريقة الدفع <span style="color:#EF4444">*</span></label>
                                <div class="payment-methods">
                                    @foreach($paymentMethods as $pm)
                                        <div class="payment-option" data-code="{{ $pm->code }}" onclick="subjectPageSelectPayment(this)">
                                            <div class="payment-radio"></div>
                                            <div class="payment-icon">📲</div>
                                            <div class="payment-name">{{ $pm->name }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="vodafoneFields" class="form-group-enroll" style="display:none">
                                <label class="enroll-label">رقم فودافون كاش <span style="color:#EF4444">*</span></label>
                                <input type="text" name="payment_phone" class="form-input enroll-select" placeholder="0100xxxxxxx">
                            </div>
                            <div id="referenceFields" class="form-group-enroll" style="display:none">
                                <label class="enroll-label">كود/مرجع التحويل <span style="color:#EF4444">*</span></label>
                                <input type="text" name="payment_reference" class="form-input" placeholder="كود التحويل">
                            </div>
                            <div class="form-group-enroll">
                                <label class="enroll-label">صورة إثبات التحويل <span style="color:var(--muted);font-weight:500">(اختياري)</span></label>
                                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('receiptFile').click()">
                                    <input type="file" id="receiptFile" name="payment_screenshot" accept="image/*" style="display:none" onchange="subjectPageHandleFileUpload(this)">
                                    <div class="upload-icon">📎</div>
                                    <div class="upload-text" id="uploadText">اضغط لرفع صورة التحويل</div>
                                    <div class="upload-hint">صورة من الشاشة أو الإيصال بعد التحويل</div>
                                </div>
                            </div>
                            <button type="submit" class="btn-enroll btn-enroll-primary" style="margin-top:4px">اشترك الآن ←</button>
                        </form>
                        <div class="enroll-info-box">
                            <span style="color:#10B981;font-size:0.9rem">ℹ️</span>
                            <span>بعد إرسال الطلب يتم مراجعة الدفع من الإدارة ثم تفعيل الاشتراك.</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Instructor --}}
        <div class="instructor-card">
            <div class="section-card-title" style="margin-bottom:14px">👨‍🏫 المدرسون</div>
            @if($subject->teachers->count() > 0)
                @foreach($subject->teachers as $teacher)
                <div class="instructor-inner">
                    <div class="instructor-avatar">{{ mb_substr($teacher->full_name ?? ($teacher->f_name . ' ' . $teacher->l_name), 0, 1) }}</div>
                    <div>
                        <div class="instructor-name">{{ $teacher->full_name ?? ($teacher->f_name . ' ' . $teacher->l_name) }}</div>
                        <div class="instructor-role">مدرس {{ $subject->name }}</div>
                    </div>
                </div>
                @if(!$loop->last)<div style="border-top:1px solid var(--border);margin-top:12px;padding-top:12px"></div>@endif
                @endforeach
            @else
                <p class="text-muted small mb-0">سيتم إضافة المدرسين قريباً.</p>
            @endif
        </div>

        {{-- Course details --}}
        <div class="section-card course-details-card">
            <div class="section-card-title">📊 تفاصيل الكورس</div>
            <div class="course-details-row">
                <span class="course-details-label">عدد الدروس</span>
                <span class="course-details-val">{{ $lectures->count() }} درس</span>
            </div>
            <div class="course-details-row">
                <span class="course-details-label">المرحلة</span>
                <span class="course-details-val">{{ $grade?->name ?? '—' }}</span>
            </div>
            <div class="course-details-row">
                <span class="course-details-label">نوع الكورس</span>
                <span class="course-details-val">فيديو + اختبارات</span>
            </div>
            <div class="course-details-row">
                <span class="course-details-label">اللغة</span>
                <span class="course-details-val">عربي</span>
            </div>
        </div>
    </div>
</div>

{{-- Lock Modal --}}
<div class="lock-overlay" id="lockOverlay" onclick="subjectPageCloseLockModal(event)">
    <div class="lock-modal" onclick="event.stopPropagation()">
        <div class="lock-modal-icon">🔒</div>
        <div class="lock-modal-title">هذا الدرس مقفول!</div>
        <div class="lock-modal-text">لمشاهدة هذا الدرس والوصول لكل محتوى الكورس، يجب عليك الاشتراك أولاً. اشترك الآن واستمتع بكل الدروس والاختبارات التفاعلية.</div>
        <div class="lock-modal-actions">
            <button type="button" class="btn-lock-enroll" onclick="subjectPageCloseLockGoEnroll()">اشترك الآن ←</button>
            <button type="button" class="btn-lock-close" onclick="subjectPageCloseLockModal()">إغلاق</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
window.subjectPageShowLockModal = function(){
    var el = document.getElementById('lockOverlay');
    if (el) el.classList.add('show');
};
window.subjectPageCloseLockModal = function(e){
    if (!e || e.target === document.getElementById('lockOverlay'))
        document.getElementById('lockOverlay').classList.remove('show');
};
window.subjectPageCloseLockGoEnroll = function(){
    document.getElementById('lockOverlay').classList.remove('show');
    var card = document.getElementById('enrollCard');
    if (card) card.scrollIntoView({ behavior: 'smooth', block: 'center' });
};
window.subjectPageScrollToEnroll = function(){
    var card = document.getElementById('enrollCard');
    if (card) card.scrollIntoView({ behavior: 'smooth', block: 'center' });
};

window.subjectPageHandleSubType = function(){
    var val = document.getElementById('subType') && document.getElementById('subType').value;
    var termGroup = document.getElementById('termNumberWrapper');
    if (termGroup) termGroup.style.display = val === 'term' ? 'block' : 'none';
};

window.subjectPageSelectPayment = function(el){
    document.querySelectorAll('.payment-option').forEach(function(o){ o.classList.remove('selected'); });
    el.classList.add('selected');
    var code = el.getAttribute('data-code');
    var input = document.getElementById('paymentMethodInput');
    if (input) input.value = code || '';
    var vodafoneFields = document.getElementById('vodafoneFields');
    var referenceFields = document.getElementById('referenceFields');
    var isVodafone = code === 'vodafone_cash';
    if (vodafoneFields) vodafoneFields.style.display = isVodafone ? 'block' : 'none';
    if (referenceFields) referenceFields.style.display = code ? 'block' : 'none';
};

window.subjectPageHandleFileUpload = function(input){
    var zone = document.getElementById('uploadZone');
    var text = document.getElementById('uploadText');
    if (input.files && input.files[0]) {
        zone.classList.add('has-file');
        text.textContent = '✅ ' + input.files[0].name;
    }
};

document.addEventListener('DOMContentLoaded', function(){
    var form = document.getElementById('enrollForm');
    if (form) {
        form.addEventListener('submit', function(e){
            var input = document.getElementById('paymentMethodInput');
            var selected = document.querySelector('.payment-option.selected');
            if (selected) {
                if (input) input.value = selected.getAttribute('data-code') || '';
            }
            if (input && !input.value) {
                e.preventDefault();
                alert('من فضلك اختر طريقة الدفع');
                return;
            }
            var subType = document.getElementById('subType');
            if (subType && !subType.value) {
                e.preventDefault();
                alert('من فضلك اختر نوع الاشتراك');
                return;
            }
            if (subType && subType.value === 'term') {
                var termNum = document.getElementById('termNum');
                if (termNum && !termNum.value) {
                    e.preventDefault();
                    alert('من فضلك اختر رقم الترم');
                    return;
                }
            }
        });
    }
    var subType = document.getElementById('subType');
    if (subType) subjectPageHandleSubType();
});
</script>
@endpush
@endsection
