@extends('front.layouts.front', ['title' => 'المواد'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">المواد</h2>
            <div class="row g-3">
                @forelse ($subjects ?? [] as $subject)
                    <div class="col-md-6 col-lg-4" id="subject-{{ $subject->id }}">
                        <div class="course-card h-100">
                            <div class="course-card-body">
                                <h5 class="course-title mb-1">{{ $subject->name }}</h5>
                                @if ($subject->grade)
                                    <p class="course-meta text-muted small mb-2">
                                        {{ $subject->grade->name }} - {{ $subject->grade->stage?->name }}
                                    </p>
                                @endif
                                <p class="small text-muted mb-3">
                                    كورس كامل يغطي منهج المادة مع حصص فيديو واختبارات.
                                </p>
                                <a href="{{ route('front.courses.subject', $subject) }}"
                                    class="btn btn-sm btn-primary w-100">
                                    عرض الكورس
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مواد حالياً.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
