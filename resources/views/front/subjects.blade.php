@extends('front.layouts.front', ['title' => 'المواد'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">المواد</h2>
            <div class="row g-3">
                @forelse (($subjects ?? []) as $subject)
                    <div class="col-md-6 col-lg-4 position-relative" id="subject-{{ $subject->id }}">
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
                                <h5 class="course-title mb-1">{{ $subject->name }}</h5>
                                @if ($subject->grade)
                                    <p class="course-meta text-muted small mb-2">
                                        {{ $subject->grade->name }} - {{ $subject->grade->stage?->name }}
                                    </p>
                                @endif
                                <p class="small text-muted mb-3">
                                    كورس كامل يغطي منهج المادة مع حصص فيديو واختبارات.
                                </p>
                                <span class="btn btn-sm btn-primary w-100">عرض الكورس</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مواد حالياً.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
