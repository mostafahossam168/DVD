@extends('front.layouts.front', ['title' => $grade->name . ' - المواد الدراسية'])

@section('content')
@php
    $gradients = [
        'linear-gradient(135deg,#0891b2,#22d3ee)',
        'linear-gradient(135deg,#1a56db,#3b82f6)',
        'linear-gradient(135deg,#7c3aed,#a78bfa)',
        'linear-gradient(135deg,#059669,#34d399)',
        'linear-gradient(135deg,#ea580c,#fb923c)',
        'linear-gradient(135deg,#e11d48,#fb7185)',
    ];
    $icons = ['🌍', '📝', '⚛️', '📐', '🔬', '🏛️'];
    $subjects = $grade->subjects ?? collect();
    $subjectCount = $subjects->count();
@endphp
<div class="grade-subj-wrap">
    <div class="subj-breadcrumb">
        <a href="{{ route('front.stages.index') }}">المراحل الدراسية</a>
        <span class="sep">/</span>
        <a href="{{ route('front.stages.show', $grade->stage) }}">{{ $grade->stage->name }}</a>
        <span class="sep">/</span>
        <span class="current">المواد الدراسية</span>
    </div>

    <div class="grade-header-card">
        <div class="ghc-info">
            <h1>المواد الدراسية</h1>
            <p>{{ $grade->stage->name }} — {{ $grade->name }}</p>
        </div>
        <div class="ghc-stats">
            <div class="ghc-stat">
                <div class="n">{{ $subjectCount }}</div>
                <div class="l">مواد متاحة</div>
            </div>
            <div class="ghc-stat">
                <div class="n">+{{ $subjectCount * 30 }}</div>
                <div class="l">حصة فيديو</div>
            </div>
            <div class="ghc-stat">
                <div class="n">+{{ $subjectCount > 0 ? number_format($subjectCount * 800) : '0' }}</div>
                <div class="l">طالب مسجل</div>
            </div>
        </div>
    </div>

    <div class="mini-grid">
        @forelse ($subjects as $index => $subject)
            <a href="{{ route('front.courses.subject', $subject) }}" class="mini-card">
                <div class="mini-card-fav" onclick="event.preventDefault(); event.stopPropagation();">
                    @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                </div>
                <div class="mini-thumb" style="background:{{ $subject->image ? 'transparent' : $gradients[$index % count($gradients)] }}">
                    @if ($subject->image)
                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="mini-thumb-img">
                    @endif
                    @if (!$subject->image)
                        <div class="watermark">{{ Str::limit($subject->name, 8, '') }}</div>
                        <div class="big-icon">{{ $icons[$index % count($icons)] }}</div>
                    @endif
                </div>
                <div class="mini-body">
                    <div class="mini-name">{{ $subject->name }}</div>
                    <div class="mini-sub">{{ $grade->name }}</div>
                    <span class="btn-mini">عرض الكورس</span>
                </div>
            </a>
        @empty
            <p class="text-muted">لا توجد مواد لهذا الصف حالياً.</p>
        @endforelse
    </div>
</div>
@endsection
