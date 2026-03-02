@extends('front.layouts.front', ['title' => $subject->name])

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <h1 class="mb-2">{{ $subject->name }}</h1>
                    <p class="text-muted mb-3">
                        {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="mb-4">
                        <h5 class="mb-2">عن الكورس</h5>
                        <p class="text-muted">
                            كورس متكامل يغطّي وحدات المنهج بحصص مسجلة على يوتيوب مع اختبارات لكل حصة لمتابعة مستواك.
                        </p>
                    </div>

                    <div>
                        <h5 class="mb-3">محتوى الكورس (الدروس)</h5>

                        @if ($lectures->count())
                            <div class="list-group">
                                @foreach ($lectures as $lecture)
                                    <a
                                        @if ($hasActiveSubscription && $student) href="{{ route('front.courses.lesson', [$subject, $lecture]) }}"
                                    @else
                                        href="javascript:void(0)" @endif
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !$lecture->status ? 'disabled' : '' }}">
                                        <div>
                                            <div class="fw-semibold">{{ $lecture->title }}</div>
                                            <div class="small text-muted">
                                                {{ \Illuminate\Support\Str::limit($lecture->description, 80) }}
                                            </div>
                                        </div>
                                        @if ($lecture->status)
                                            <span class="badge bg-primary rounded-pill">
                                                @if ($hasActiveSubscription && $student)
                                                    مشاهدة
                                                @else
                                                    مغلقة حتى الاشتراك
                                                @endif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">غير متاحة</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">لم يتم إضافة دروس لهذا الكورس بعد.</p>
                        @endif
                    </div>
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

