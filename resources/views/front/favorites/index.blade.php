@extends('front.layouts.front', ['title' => 'المفضلة'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">المفضلة</h2>
            <p class="text-muted mb-4">الكورسات التي أضفتها للمفضلة.</p>

            @if ($subjects->count())
                <div class="row g-3">
                    @foreach ($subjects as $subject)
                        <div class="col-md-6 col-lg-4 position-relative">
                            <a href="{{ route('front.courses.subject', $subject) }}" class="course-card course-card-with-img card shadow-sm h-100 text-decoration-none overflow-hidden">
                                <div class="favorite-btn-wrap position-absolute top-0 end-0 m-2">
                                    @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => true])
                                </div>
                                @if ($subject->image)
                                    <div class="course-card-img-wrap">
                                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="course-card-img">
                                    </div>
                                @endif
                                <div class="course-card-body">
                                    <h5 class="course-title mb-1">{{ $subject->name }}</h5>
                                    <p class="course-meta small text-muted mb-2">
                                        {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
                                    </p>
                                    <span class="btn btn-sm btn-primary w-100">عرض الكورس</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">لم تضف أي كورسات للمفضلة بعد. <a href="{{ route('front.courses.index') }}">استكشف الكورسات</a> وأضف ما يعجبك.</p>
            @endif
        </div>
    </section>
@endsection
