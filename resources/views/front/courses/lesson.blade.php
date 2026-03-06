@extends('front.layouts.front', ['title' => $title ?? ('فاهم — ' . $lecture->title)])

@section('content')
@php
    $grade = $subject->grade;
    $stage = $grade?->stage;
    $lectures = $lectures ?? collect();
    $totalLectures = $totalLectures ?? 0;
    $currentIndex = (int) ($currentIndex ?? 0);
    $progressPct = (int) ($progressPct ?? 0);
    $prevLecture = $prevLecture ?? null;
    $nextLecture = $nextLecture ?? null;
    $embedUrl = $embedUrl ?? null;
    $hasQuizResult = $hasQuizResult ?? false;
    $materials = $materials ?? collect();
@endphp

<div class="lesson-page-wrap">
<div class="lesson-layout">
    <div class="lesson-main">
        <div class="lesson-breadcrumb">
            <a href="{{ route('front.courses.index') }}">الكورسات</a>
            <span class="breadcrumb-sep">/</span>
            <a href="{{ route('front.courses.subject', $subject) }}">{{ $subject->name }}</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-cur">{{ $lecture->title }}</span>
        </div>

        <div class="video-wrap" id="videoWrap">
            @if($embedUrl)
            <div class="video-placeholder" id="videoPlaceholder" data-embed="{{ $embedUrl }}">
                <div class="play-btn">▶</div>
                <div class="video-placeholder-text">اضغط لتشغيل الدرس</div>
            </div>
            @else
            <div class="video-placeholder">
                <div class="video-placeholder-text">لا يوجد فيديو مضمن</div>
                @if($lecture->link)
                <a href="{{ $lecture->link }}" target="_blank" rel="noopener" style="color:#93C5FD;font-weight:700">فتح الرابط ←</a>
                @endif
            </div>
            @endif
        </div>

        <div class="video-meta-bar">
            <div>
                <div class="lesson-title-main">{{ $lecture->title }}</div>
                <div class="lesson-sub">{{ $subject->name }} — {{ $grade?->name ?? '—' }} — {{ $stage?->name ?? '—' }}</div>
            </div>
            <div class="meta-actions">
                <button type="button" class="meta-btn" id="markDoneBtn">☑ تحديد كمكتمل</button>
            </div>
        </div>

        <div class="lesson-content">
            @if($lecture->description)
            <div class="content-section">
                <div class="content-section-title">وصف الدرس</div>
                <div class="desc-text">{!! nl2br(e($lecture->description)) !!}</div>
            </div>
            @endif

            @if($materials->count() > 0)
            <div class="content-section">
                <div class="content-section-title">ملفات الدرس</div>
                <div class="files-list">
                    @foreach($materials as $material)
                    <a href="{{ display_file($material->file) }}" target="_blank" rel="noopener" class="file-item">
                        <div class="file-icon">📄</div>
                        <div class="file-info">
                            <div class="file-name">{{ $material->title }}</div>
                            <div class="file-size">تحميل</div>
                        </div>
                        <span class="file-download">⬇ تحميل</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="lesson-nav">
                @if($prevLecture)
                <a href="{{ route('front.courses.lesson', [$subject, $prevLecture]) }}" class="nav-lesson-btn">
                    <span class="nlb-arrow">←</span>
                    <div>
                        <div class="nlb-label">السابق</div>
                        <div class="nlb-title">{{ $prevLecture->title }}</div>
                    </div>
                </a>
                @else
                <div class="nav-lesson-btn" style="opacity:0.6;cursor:default">
                    <span class="nlb-arrow">←</span>
                    <div>
                        <div class="nlb-label">السابق</div>
                        <div class="nlb-title">لا يوجد درس سابق</div>
                    </div>
                </div>
                @endif
                @if($nextLecture)
                <a href="{{ route('front.courses.lesson', [$subject, $nextLecture]) }}" class="nav-lesson-btn next">
                    <span class="nlb-arrow">→</span>
                    <div>
                        <div class="nlb-label">التالي</div>
                        <div class="nlb-title">{{ $nextLecture->title }}</div>
                    </div>
                </a>
                @else
                <div class="nav-lesson-btn next" style="opacity:0.6;cursor:default">
                    <span class="nlb-arrow">→</span>
                    <div>
                        <div class="nlb-label">التالي</div>
                        <div class="nlb-title">لا يوجد درس تالي</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <aside class="lesson-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-title">تقدمك في الكورس</div>
            <div class="progress-wrap">
                <div class="progress-label-row">
                    <span class="progress-label-text">{{ $currentIndex + 1 }} من {{ $totalLectures }} درس</span>
                    <span class="progress-pct">{{ $progressPct }}٪</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:{{ $progressPct }}%"></div>
                </div>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-title">قائمة الدروس</div>
            @foreach($lectures as $idx => $lec)
                @php
                    $isActive = $lec->id === $lecture->id;
                    $isPast = $idx < $currentIndex;
                    $isLocked = $idx > $currentIndex;
                @endphp
                @if($isActive)
                <div class="playlist-item active">
                    <div class="pl-num pl-num-active">▶</div>
                    <div class="pl-info">
                        <div class="pl-title">{{ $lec->title }}</div>
                        <div class="pl-meta">{{ $lec->materials_count ?? 0 }} مادة @if($quiz && $lec->id === $lecture->id) • ١ اختبار @endif</div>
                    </div>
                    <span class="pl-status status-now">الآن</span>
                </div>
                @elseif($isPast)
                <a href="{{ route('front.courses.lesson', [$subject, $lec]) }}" class="playlist-item">
                    <div class="pl-num pl-num-done">✓</div>
                    <div class="pl-info">
                        <div class="pl-title">{{ $lec->title }}</div>
                        <div class="pl-meta">{{ $lec->materials_count ?? 0 }} مادة</div>
                    </div>
                    <span class="pl-status status-done">✓ مكتمل</span>
                </a>
                @else
                <a href="{{ route('front.courses.lesson', [$subject, $lec]) }}" class="playlist-item">
                    <div class="pl-num pl-num-next">{{ $idx + 1 }}</div>
                    <div class="pl-info">
                        <div class="pl-title">{{ $lec->title }}</div>
                        <div class="pl-meta">{{ $lec->materials_count ?? 0 }} مادة</div>
                    </div>
                    <span class="pl-status status-lock">→</span>
                </a>
                @endif
            @endforeach
        </div>

        @if($quiz)
        <div class="sidebar-section">
            <div class="sidebar-title">اختبار الدرس</div>
            <div class="quiz-card">
                <div class="quiz-card-title">📝 {{ $quiz->title }}</div>
                <div class="quiz-info-row">
                    <span class="quiz-info-text">عدد الأسئلة: {{ $quiz->questions_count ?? $quiz->questions()->count() }}</span>
                    @if($hasQuizResult)
                    <span class="quiz-done-badge">✓ تم الحل مسبقاً</span>
                    @endif
                </div>
                @if($hasQuizResult)
                <a href="{{ route('front.quizzes.review', $quiz) }}" class="btn-quiz-view">عرض الاختبار ←</a>
                @else
                <a href="{{ route('front.quizzes.show', $quiz) }}" class="btn-quiz-view">بدء الاختبار ←</a>
                @endif
            </div>
        </div>
        @endif

        <div class="sidebar-section">
            <div class="sidebar-title">الكورس</div>
            <div class="course-sidebar-card">
                <div class="course-icon">📖</div>
                <div>
                    <div class="course-sidebar-name">{{ $subject->name }}</div>
                    <div class="course-sidebar-path">{{ $grade?->name ?? '—' }} — {{ $stage?->name ?? '—' }}</div>
                </div>
            </div>
            <a href="{{ route('front.courses.subject', $subject) }}" class="btn-back-course">← الرجوع لصفحة الكورس</a>
        </div>
    </aside>
</div>
</div>

@if($embedUrl)
@push('scripts')
<script>
(function(){
  var placeholder = document.getElementById('videoPlaceholder');
  if (!placeholder) return;
  var embed = placeholder.getAttribute('data-embed');
  if (!embed) return;
  placeholder.addEventListener('click', function(){
    placeholder.style.display = 'none';
    var wrap = document.getElementById('videoWrap');
    var iframe = document.createElement('iframe');
    iframe.src = embed + (embed.indexOf('?') >= 0 ? '&' : '?') + 'autoplay=1&rel=0&modestbranding=1';
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
    iframe.allowFullscreen = true;
    iframe.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:none';
    wrap.appendChild(iframe);
  });
})();
</script>
@endpush
@endif
@endsection
