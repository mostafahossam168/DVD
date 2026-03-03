@extends('front.layouts.front', ['title' => 'الكورسات'])

@section('content')
    {{-- Header --}}
    <section class="courses-page-hero py-4">
        <div class="container">
            <h1 class="courses-page-title mb-2">كل الكورسات المتاحة</h1>
            <p class="courses-page-subtitle text-muted mb-0">اختر مرحلتك الدراسية ثم الصف والمادة لبدء التعلّم.</p>
        </div>
    </section>

    <section class="courses-page-content py-4 pb-5">
        <div class="container">
            @forelse ($stages as $stage)
                <div class="courses-stage-block mb-5" id="stage-{{ $stage->id }}">
                    <h2 class="courses-stage-title mb-3 text-center">
                        <a href="{{ route('front.stages.show', $stage) }}" class="text-decoration-none">{{ $stage->name }}</a>
                    </h2>

                    @forelse ($stage->grades as $grade)
                        @if ($grade->subjects->count())
                            <div class="courses-grade-block mb-4">
                                <h3 class="courses-grade-title mb-3 text-center">
                                    <a href="{{ route('front.grades.show', $grade) }}" class="text-muted text-decoration-none">{{ $grade->name }}</a>
                                </h3>
                                <div class="row g-3">
                                    @foreach ($grade->subjects as $subject)
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <a href="{{ route('front.courses.subject', $subject) }}" class="course-card course-card-with-img card shadow-sm h-100 text-decoration-none overflow-hidden">
                                                <div class="favorite-btn-wrap position-absolute top-0 end-0 m-2">
                                                    @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                                                </div>
                                                @if ($subject->image)
                                                    <div class="course-card-img-wrap">
                                                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="course-card-img">
                                                    </div>
                                                @endif
                                                <div class="course-card-body">
                                                    <h5 class="course-index-title">{{ $subject->name }}</h5>
                                                    <p class="course-index-meta text-muted mb-2">
                                                        {{ $grade->name }} — {{ $stage->name }}
                                                    </p>
                                                    @auth
                                                        @php
                                                            $isSubscribed = in_array($subject->id, $subscribedSubjectIds ?? []);
                                                        @endphp
                                                        @if ($isSubscribed)
                                                            <span class="badge bg-success rounded-pill mb-2">مشترك</span>
                                                        @endif
                                                    @endauth
                                                    <p class="course-index-desc text-muted small mb-2">
                                                        كورس كامل يغطي منهج المادة مع حصص فيديو واختبارات تفاعلية.
                                                    </p>
                                                    <span class="btn btn-sm btn-primary w-100 rounded-pill">عرض تفاصيل الكورس</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-muted">لا توجد صفوف لهذه المرحلة حالياً.</p>
                    @endforelse
                </div>
            @empty
                <p class="text-muted">لا توجد مراحل دراسية حالياً.</p>
            @endforelse
        </div>
    </section>
@endsection

