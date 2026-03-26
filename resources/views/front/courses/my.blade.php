@extends('front.layouts.front', ['title' => 'فاهم — كورساتي'])

@section('content')
@php
    $subscriptions = $subscriptions ?? collect();
@endphp

<div class="hero-band hero-courses">
    <div class="hero-inner">
        <div class="hero-eyebrow">🎓 كورساتي</div>
        <h1>كل الكورسات التي <em>اشتركت فيها</em></h1>
        <p>تابع دروسك وتقييماتك من مكان واحد بسرعة وسهولة.</p>
    </div>
</div>

<div class="page-content courses-page-content" style="padding:32px 5% 80px">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($subscriptions->count())
        <div class="courses-grid">
            @foreach($subscriptions as $subscription)
                @php($subject = $subscription->subject)
                @continue(!$subject)
                <a href="{{ route('front.courses.subject', $subject) }}" class="course-card course-card-with-img" style="position:relative">
                    <div class="favorite-btn-wrap position-absolute top-0 start-0 m-2" style="z-index:2">
                        @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                    </div>
                    <div class="course-card-img-wrap">
                        @if($subject->image)
                            <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="course-card-img">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="font-size:2rem;color:#94a3b8">📘</div>
                        @endif
                    </div>
                    <div class="course-card-body">
                        <div class="card-subject">{{ $subject->name }}</div>
                        <div class="card-title">{{ $subject->name }}</div>
                        <div class="card-meta">{{ $subject->grade?->name ?? '—' }} — {{ $subject->grade?->stage?->name ?? '—' }}</div>
                        <div class="card-tags">
                            <span class="tag">✅ اشتراك مفعل</span>
                            @if($subscription->period_type === 'term')
                                <span class="tag">📅 ترم {{ $subscription->term_number ? 'رقم '.$subscription->term_number : '' }}</span>
                            @else
                                <span class="tag">📆 اشتراك شهري</span>
                            @endif
                        </div>
                        <div class="card-footer" style="margin-top:auto">
                            <span class="btn-card">دخول الكورس</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state show">
            <div class="empty-icon">📚</div>
            <div class="empty-title">لا توجد كورسات مسجل فيها حاليًا</div>
            <div class="empty-sub">ابدأ الآن واستكشف الكورسات المتاحة.</div>
            <a href="{{ route('front.courses.index') }}" class="btn-browse">استكشف الكورسات</a>
        </div>
    @endif
</div>
@endsection

