@extends('front.layouts.front', ['title' => 'كورساتي'])

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">كورساتي</h2>
                    <p class="text-muted mb-0">جميع المواد التي أنت مشترك فيها حالياً.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($subscriptions->count())
                <div class="row g-3">
                    @foreach ($subscriptions as $subscription)
                        @php($subject = $subscription->subject)
                        @continue(!$subject)
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
                                    <h5 class="course-title mb-1">{{ $subject->name }}</h5>
                                    <p class="course-meta small text-muted mb-2">
                                        {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
                                    </p>
                                    <span class="badge bg-success mb-2">اشتراك مفعل</span>
                                    <p class="small text-muted mb-3">
                                        نوع الفترة:
                                        @if ($subscription->period_type === 'term')
                                            ترم @if ($subscription->term_number)
                                                رقم {{ $subscription->term_number }}
                                            @endif
                                        @else
                                            من {{ optional($subscription->start_date)->format('Y-m-d') }}
                                            إلى {{ optional($subscription->end_date)->format('Y-m-d') }}
                                        @endif
                                    </p>
                                    <span class="btn btn-primary btn-sm w-100">دخول الكورس</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">
                    لا توجد كورسات مسجل فيها حالياً.
                    <a href="{{ route('front.courses.index') }}">استكشف الكورسات المتاحة</a>.
                </p>
            @endif
        </div>
    </section>
@endsection

