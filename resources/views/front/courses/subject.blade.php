@extends('front.layouts.front', ['title' => $subject->name])

@section('content')
    <section class="py-5 subject-page">
        <div class="container">
            {{-- Breadcrumbs --}}
            <nav class="subject-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.courses.index') }}">الكورسات</a></li>
                    @if ($subject->grade?->stage)
                        <li class="breadcrumb-item"><a href="{{ route('front.courses.index') }}#stage-{{ $subject->grade->stage->id }}">{{ $subject->grade->stage->name }}</a></li>
                    @endif
                    @if ($subject->grade)
                        <li class="breadcrumb-item"><a href="{{ route('front.courses.index') }}#stage-{{ $subject->grade->stage?->id ?? $subject->grade->id }}">{{ $subject->grade->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Unit Header Banner --}}
            <div class="subject-header-banner rounded-3 mb-4 py-4 px-4 d-flex align-items-center gap-4 position-relative">
                <div class="favorite-btn-wrap position-absolute top-0 end-0 m-3">
                    @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => $isFavorite ?? false])
                </div>
                @if ($subject->image)
                    <div class="subject-header-img-wrap flex-shrink-0">
                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="subject-header-img">
                    </div>
                @endif
                <div class="{{ $subject->image ? 'text-start' : 'text-center w-100' }}">
                    <h1 class="subject-header-title mb-1">{{ $subject->name }}</h1>
                    <p class="subject-header-subtitle text-muted mb-0">
                        {{ $subject->grade?->name }} — {{ $subject->grade?->stage?->name ?? '' }}
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    {{-- Lesson Cards Grid --}}
                    @if ($lectures->count())
                        <div class="row g-3 mb-4">
                            @foreach ($lectures as $lecture)
                                @php
                                    $canAccess = $hasActiveSubscription && $student && $lecture->status;
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ $canAccess ? route('front.courses.lesson', [$subject, $lecture]) : 'javascript:void(0)' }}"
                                       class="lesson-card card h-100 text-decoration-none {{ !$canAccess ? 'lesson-card-locked' : '' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="lesson-card-title mb-0">{{ $lecture->title }}</h6>
                                                @if (!$canAccess)
                                                    <i class="fa-solid fa-lock text-muted small"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-play text-primary"></i>
                                                @endif
                                            </div>
                                            <p class="lesson-card-desc small text-muted mb-2">
                                                {{ \Illuminate\Support\Str::limit($lecture->description ?? '', 60) }}
                                            </p>
                                            <div class="lesson-card-meta small text-muted">
                                                <i class="fa-regular fa-folder-open me-1"></i>
                                                {{ $lecture->materials_count ?? 0 }} مواد
                                                @if ($lecture->has_quiz ?? false)
                                                    <span class="me-1">—</span>
                                                    <i class="fa-solid fa-pen-to-square me-1"></i>اختبار
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Bottom Cards: Exam + Summary --}}
                        <div class="row g-3 mt-4">
                            @if ($firstLectureWithQuiz && $hasActiveSubscription && $student)
                                <div class="col-md-6">
                                    <a href="{{ route('front.courses.lesson', [$subject, $firstLectureWithQuiz]) }}#quiz" class="subject-bottom-card subject-exam-card text-decoration-none">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">اختبارات الدروس</h6>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div>
                                        <p class="small text-muted mb-2">اختبر مستواك وفهمك لكل درس.</p>
                                        <span class="btn-exam">امتحان</span>
                                    </a>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="subject-bottom-card subject-summary-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">ملخص الكورس</h6>
                                        <i class="fa-solid fa-file-pdf text-muted"></i>
                                    </div>
                                    <p class="small text-muted mb-0">تأكد من فهمك لكل الدروس عبر مراجعة المحتوى.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">لم يتم إضافة دروس لهذا الكورس بعد.</p>
                    @endif

                    {{-- Online Meetings (حصص لايف) --}}
                    @if (($onlineMeetings ?? collect())->count() > 0)
                        <div class="subject-online-meetings-section mt-5 pt-4">
                            <h6 class="section-heading mb-3">حصص لايف</h6>
                            <div class="d-flex flex-column gap-3">
                                @foreach ($onlineMeetings as $meeting)
                                    <div class="online-meeting-item card shadow-sm border-0">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-2 flex-grow-1 min-w-0">
                                                <i class="fa-solid fa-video text-danger flex-shrink-0"></i>
                                                <div>
                                                    <span class="fw-semibold small">{{ $meeting->topic }}</span>
                                                    <span class="text-muted small d-block">
                                                        {{ $meeting->start_time?->translatedFormat('l j F Y') }} — {{ $meeting->start_time?->format('H:i') }}
                                                    </span>
                                                </div>
                                            </div>
                                            @if ($hasActiveSubscription && $student && $meeting->join_url)
                                                <a href="{{ $meeting->join_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger flex-shrink-0">
                                                    <i class="fa-solid fa-video me-1"></i>دخول زوم
                                                </a>
                                            @elseif ($meeting->join_url)
                                                <span class="badge bg-secondary small">اشترك للدخول</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2">الاشتراك في الكورس</h5>

                            @if ($student && $hasActiveSubscription)
                                <p class="text-success mb-2">
                                    أنت مشترك حالياً في هذا الكورس.
                                </p>
                                <a href="{{ route('front.courses.my') }}" class="btn btn-outline-primary w-100 mb-2">
                                    الذهاب إلى كورساتي
                                </a>

                                @if ($canRate)
                                    <hr>
                                    <h6 class="mb-2">قيّم هذا الكورس</h6>
                                    <form method="POST" action="{{ route('front.courses.rate', $subject) }}">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">التقييم (١–٥ نجوم)</label>
                                            <select name="rating" class="form-select" required>
                                                <option value="">-- اختر --</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">اكتب رأيك (10 حروف على الأقل)</label>
                                            <textarea name="review_text" class="form-control" rows="3" minlength="10" required placeholder="شاركنا تجربتك مع الكورس"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">إرسال التقييم</button>
                                    </form>
                                @elseif ($hasRated)
                                    <hr>
                                    <p class="text-success mb-0">✓ تم تقييمك لهذا الكورس.</p>
                                @endif
                            @elseif(!$student)
                                <p class="text-muted mb-2">
                                    سجّل الدخول كطالب للاشتراك في الكورس.
                                </p>
                                <a href="{{ route('front.login') }}" class="btn btn-primary w-100 mb-2">
                                    تسجيل الدخول
                                </a>
                                <a href="{{ route('front.register') }}" class="btn btn-outline-secondary w-100">
                                    إنشاء حساب جديد
                                </a>
                            @else
                                @if($paymentMethods->isEmpty())
                                    <p class="text-muted mb-2">لا توجد حالياً طرق دفع مفعلة للاشتراك. تواصل مع الإدارة.</p>
                                @else
                                    <form method="POST" action="{{ route('front.courses.subscribe', $subject) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">نوع الاشتراك</label>
                                            <select name="period_type" class="form-select">
                                                <option value="term" selected>ترم دراسي (افتراضي)</option>
                                                <option value="month">شهر</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="termNumberWrapper">
                                            <label class="form-label">رقم الترم</label>
                                            <select name="term_number" class="form-select">
                                                <option value="1" selected>الأول</option>
                                                <option value="2">الثاني</option>
                                                <option value="3">الثالث</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">طريقة الدفع</label>
                                            <select name="payment_method" id="paymentMethodSelect" class="form-select" required>
                                                <option value="">-- اختر طريقة الدفع --</option>
                                                @foreach($paymentMethods as $pm)
                                                    <option value="{{ $pm->code }}">{{ $pm->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="vodafoneFields" class="payment-fields mb-2" style="display:none;">
                                            <label class="form-label">رقم فودافون كاش الذي تم التحويل منه</label>
                                            <input type="text" name="payment_phone" id="paymentPhone" class="form-control" placeholder="مثال: 0100xxxxxxx">
                                        </div>
                                        <div id="referenceFields" class="payment-fields mb-2" style="display:none;">
                                            <label class="form-label">كود/مرجع عملية التحويل</label>
                                            <input type="text" name="payment_reference" id="paymentReference" class="form-control" placeholder="كود أو مرجع التحويل">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">صورة إثبات التحويل (اختياري)</label>
                                            <input type="file" name="payment_screenshot" class="form-control" accept="image/*">
                                            <small class="text-muted">صورة من الشاشة أو الإيصال بعد التحويل</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            اشترك الآن
                                        </button>
                                    </form>
                                    <p class="small text-muted mt-2">
                                        بعد إرسال الطلب يتم مراجعة الدفع من الإدارة ثم تفعيل الاشتراك.
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-body">
                            <h6 class="card-title mb-2">المدرسون</h6>
                            @if ($subject->teachers->count())
                                <ul class="list-unstyled mb-0 small">
                                    @foreach ($subject->teachers as $teacher)
                                        <li class="mb-1">
                                            {{ $teacher->full_name ?? ($teacher->f_name . ' ' . $teacher->l_name) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted small mb-0">سيتم إضافة بيانات المدرس قريباً.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- تقييمات الكورس --}}
            @if (($reviews ?? collect())->count() > 0)
                <div class="subject-reviews-section mt-5 pt-4 border-top">
                    <h4 class="mb-3">تقييمات الطلاب</h4>
                    <div class="row g-3">
                        @foreach ($reviews as $review)
                            <div class="col-12">
                                <div class="subject-review-card card shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start gap-3">
                                            @php
                                                $studentImage = $review->user?->image ?? $review->image;
                                            @endphp
                                            @if ($studentImage)
                                                <img src="{{ display_file($studentImage) }}" class="rounded-circle subject-review-avatar" alt="{{ $review->name }}">
                                            @else
                                                <div class="subject-review-avatar subject-review-avatar-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-user text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-1">
                                                    <strong>{{ $review->name }}</strong>
                                                    <div class="d-flex align-items-center text-warning">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa-{{ $i <= (int) $review->rating ? 'solid' : 'regular' }} fa-star small"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                @if ($review->user?->phone)
                                                    <p class="mb-1 text-muted small">{{ $review->user->phone }}</p>
                                                @endif
                                                <p class="mb-0 text-muted">{{ $review->review_text }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            const periodSelect = document.querySelector('select[name="period_type"]');
            const termWrapper = document.getElementById('termNumberWrapper');
            if (periodSelect && termWrapper) {
                periodSelect.addEventListener('change', function() {
                    termWrapper.style.display = this.value === 'term' ? '' : 'none';
                });
            }
            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            const vodafoneFields = document.getElementById('vodafoneFields');
            const referenceFields = document.getElementById('referenceFields');
            const paymentPhone = document.getElementById('paymentPhone');
            const paymentReference = document.getElementById('paymentReference');
            function togglePaymentFields() {
                const code = paymentMethodSelect ? paymentMethodSelect.value : '';
                const isVodafone = code === 'vodafone_cash';
                if (vodafoneFields) vodafoneFields.style.display = isVodafone ? 'block' : 'none';
                if (referenceFields) referenceFields.style.display = code ? 'block' : 'none';
                if (paymentPhone) paymentPhone.required = isVodafone;
                if (paymentReference) paymentReference.required = isVodafone;
            }
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', togglePaymentFields);
                togglePaymentFields();
            }
        </script>
    @endpush
@endsection

