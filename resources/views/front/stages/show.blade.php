@extends('front.layouts.front', ['title' => $stage->name])

@section('content')
    {{-- 1. Hero Banner - Dark blue مع تصميم يشبه الطباشير --}}
    <section class="stage-hero-banner">
        <div class="stage-hero-overlay"></div>
        <div class="container position-relative">
            <div class="stage-hero-content text-center text-white py-5">
                <h1 class="stage-hero-title mb-3">{{ $stage->name }}</h1>
                <p class="stage-hero-desc mb-4">أساس تعليمي قوي بأسلوب سهل يناسب كل طالب. مع امتحانات ومتابعة مستمرة.</p>
                <a href="#grades-section" class="btn btn-stage-cta">ابدأ الآن</a>
            </div>
        </div>
    </section>

    {{-- 2. اختَر صفك الدراسي + كروت الصفوف --}}
    <section class="stage-grades-section py-5" id="grades-section">
        <div class="container">
            <h2 class="stage-section-title text-center mb-4">اختر صفك الدراسي</h2>
            <div class="row g-4 justify-content-center">
                @forelse ($stage->grades as $grade)
                    @if (($grade->subjects_count ?? $grade->subjects->count() ?? 0) > 0)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('front.grades.show', $grade) }}" class="grade-card-modern card text-decoration-none h-100 position-relative">
                                <div class="grade-card-ghost">{{ $grade->name }}</div>
                                <div class="card-body position-relative">
                                    <div class="grade-card-icon"><i class="fa-solid fa-leaf"></i></div>
                                    <h5 class="grade-card-title">{{ $grade->name }}</h5>
                                    <span class="btn btn-grade-detail">عرض التفاصيل</span>
                                </div>
                            </a>
                        </div>
                    @endif
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">لا توجد صفوف لهذه المرحلة حالياً.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 3. ماذا ستتعلم معنا؟ --}}
    <section class="stage-benefits-section py-5 bg-white">
        <div class="container">
            <h2 class="stage-benefits-title text-center mb-2">ماذا ستتعلم معنا؟</h2>
            <p class="stage-benefits-subtitle text-center text-muted mb-5">مش بس منهج... مهارات ومعرفة تفضل معاك دراسياً.</p>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 g-lg-4 mb-4">
                <div class="col">
                    <div class="benefit-card benefit-card-orange">
                        <i class="fa-solid fa-brain benefit-icon"></i>
                        <p class="benefit-text mb-0">فهم عميق للمناهج الدراسية</p>
                    </div>
                </div>
                <div class="col">
                    <div class="benefit-card benefit-card-blue">
                        <i class="fa-solid fa-bullseye benefit-icon"></i>
                        <p class="benefit-text mb-0">الفهم والتطبيق لراحة النظام</p>
                    </div>
                </div>
                <div class="col">
                    <div class="benefit-card benefit-card-orange">
                        <i class="fa-solid fa-pen-to-square benefit-icon"></i>
                        <p class="benefit-text mb-0">حل الامتحانات بثقة</p>
                    </div>
                </div>
                <div class="col">
                    <div class="benefit-card benefit-card-blue">
                        <i class="fa-solid fa-chart-line benefit-icon"></i>
                        <p class="benefit-text mb-0">تطبيق وجب التحاليل بنجاح</p>
                    </div>
                </div>
                <div class="col">
                    <div class="benefit-card benefit-card-orange">
                        <i class="fa-solid fa-chart-bar benefit-icon"></i>
                        <p class="benefit-text mb-0">متابعة مستواك ومعرفة نقاطك</p>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('front.contact') }}" class="btn btn-benefits-cta">تواصل معنا</a>
            </div>
        </div>
    </section>
@endsection
