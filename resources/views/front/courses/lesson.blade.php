@extends('front.layouts.front', ['title' => $lecture->title])

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <h1 class="mb-2">{{ $lecture->title }}</h1>
                    <p class="text-muted mb-3">
                        {{ $subject->name }} - {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($embedUrl)
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="{{ $embedUrl }}" title="{{ $lecture->title }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            لا يمكن عرض الفيديو داخل الصفحة، يمكنك مشاهدته من خلال الرابط:
                            <a href="{{ $lecture->link }}" target="_blank" rel="noopener">فتح الفيديو</a>
                        </div>
                    @endif

                    <div class="mt-3">
                        <h5 class="mb-2">وصف الدرس</h5>
                        <p class="text-muted">
                            {!! nl2br(e($lecture->description)) !!}
                        </p>
                    </div>

                    @if ($materials->count())
                        <div class="mt-4">
                            <h5 class="mb-2">ملفات الدرس</h5>
                            <div class="list-group">
                                @foreach ($materials as $material)
                                    <a href="{{ display_file($material->file) }}" target="_blank" rel="noopener"
                                        class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-file"></i>
                                        <span>{{ $material->title }}</span>
                                        <span class="badge bg-secondary ms-auto"><i class="fa-solid fa-download"></i> تحميل</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    @if ($quiz)
                        <div id="quiz" class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-2">اختبار هذه الحصة</h5>
                                <p class="small text-muted mb-2">
                                    عدد الأسئلة: {{ $quiz->questions_count }}
                                </p>
                                @if ($hasQuizResult)
                                    <p class="text-success small mb-2">
                                        تم حل هذا الاختبار مسبقاً.
                                    </p>
                                    <a href="{{ route('front.quizzes.review', $quiz) }}" class="btn btn-outline-primary w-100">
                                        عرض هذا الاختبار
                                    </a>
                                @else
                                    <a href="{{ route('front.quizzes.show', $quiz) }}" class="btn btn-primary w-100">
                                        بدء الاختبار
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-2">الكورس</h6>
                            <p class="small mb-2">{{ $subject->name }}</p>
                            <a href="{{ route('front.courses.subject', $subject) }}" class="btn btn-outline-secondary w-100">
                                الرجوع لصفحة الكورس
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

