@extends('front.layouts.front', ['title' => 'الكورسات'])

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">كل الكورسات المتاحة</h2>
                    <p class="text-muted mb-0">اختر مرحلتك الدراسية ثم الصف والمادة لبدء التعلّم.</p>
                </div>
            </div>

            @forelse ($stages as $stage)
                <div class="mb-5" id="stage-{{ $stage->id }}">
                    <h4 class="mb-3">{{ $stage->name }}</h4>

                    @forelse ($stage->grades as $grade)
                        @if ($grade->subjects->count())
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">{{ $grade->name }}</h6>
                                <div class="row g-3">
                                    @foreach ($grade->subjects as $subject)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="course-card h-100">
                                                <div class="course-card-body">
                                                    <h5 class="course-title mb-1">{{ $subject->name }}</h5>
                                                    <p class="course-meta small text-muted mb-2">
                                                        {{ $grade->name }} - {{ $stage->name }}
                                                    </p>
                                                    @auth
                                                        @php
                                                            $isSubscribed = in_array($subject->id, $subscribedSubjectIds ?? []);
                                                        @endphp
                                                        @if ($isSubscribed)
                                                            <span class="badge bg-success mb-2">مشترك</span>
                                                        @endif
                                                    @endauth
                                                    <p class="small text-muted mb-3">
                                                        كورس كامل يغطي منهج المادة مع حصص فيديو واختبارات تفاعلية.
                                                    </p>
                                                    <a href="{{ route('front.courses.subject', $subject) }}"
                                                        class="btn btn-sm btn-primary w-100">
                                                        عرض تفاصيل الكورس
                                                    </a>
                                                </div>
                                            </div>
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

