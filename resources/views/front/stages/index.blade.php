@extends('front.layouts.front', ['title' => 'المراحل الدراسية'])

@section('content')
    <section class="py-5 stages-page">
        <div class="container">
            <h2 class="mb-4">المراحل الدراسية</h2>
            <p class="text-muted mb-4">اختر مرحلتك الدراسية لعرض الصفوف والمواد المتاحة.</p>
            <div class="row g-3">
                @forelse (($stages ?? []) as $stage)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('front.stages.show', $stage) }}" class="stage-card card shadow-sm text-decoration-none h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa-solid fa-graduation-cap text-primary me-3 fs-4"></i>
                                <h5 class="card-title mb-0">{{ $stage->name }}</h5>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مراحل دراسية حالياً.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
