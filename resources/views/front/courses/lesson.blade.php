@extends('front.layouts.front', ['title' => $title ?? 'فاهم — ' . $lecture->title])

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
        $assessment = $assessment ?? null;
        $hasAssessmentResult = $hasAssessmentResult ?? false;
        $materials = $materials ?? collect();
        $videoId = $videoId ?? null;
        $progress = $progress ?? null;
        $resumeSeconds = !$progress || $progress->completed ? 0 : (int) $progress->last_position_seconds;
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
                    @if ($videoId)
                        <div class="video-placeholder" id="videoPlaceholder" data-video-id="{{ $videoId }}"
                            data-resume="{{ $resumeSeconds }}">
                            <div class="play-btn">▶</div>
                            <div class="video-placeholder-text">اضغط لتشغيل الدرس</div>
                            @if ($resumeSeconds > 0)
                                <div class="video-placeholder-resume">استكمل من الدقيقة
                                    {{ sprintf('%d:%02d', intdiv($resumeSeconds, 60), $resumeSeconds % 60) }}</div>
                            @endif
                        </div>
                        <div id="ytPlayer" style="display:none"></div>
                    @else
                        <div class="video-placeholder">
                            <div class="video-placeholder-text">لا يوجد فيديو مضمن</div>
                            @if ($lecture->link)
                                <a href="{{ $lecture->link }}" target="_blank" rel="noopener"
                                    style="color:#93C5FD;font-weight:700">فتح الرابط ←</a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="video-meta-bar">
                    <div>
                        <div class="lesson-title-main">{{ $lecture->title }}</div>
                        <div class="lesson-sub">{{ $subject->name }} — {{ $grade?->name ?? '—' }} —
                            {{ $stage?->name ?? '—' }}</div>
                    </div>
                    <div class="meta-actions">
                        <button type="button" class="meta-btn" id="markDoneBtn"
                            data-completed="{{ $progress && $progress->completed ? '1' : '0' }}">
                            {{ $progress && $progress->completed ? '✅ تمت المشاهدة' : '☑ تحديد كمكتمل' }}
                        </button>
                    </div>
                </div>

                <div class="lesson-content">
                    @if ($lecture->description)
                        <div class="content-section">
                            <div class="content-section-title">وصف الدرس</div>
                            <div class="desc-text">{!! nl2br(e($lecture->description)) !!}</div>
                        </div>
                    @endif

                    @if ($materials->count() > 0)
                        <div class="content-section">
                            <div class="content-section-title">ملفات الدرس</div>
                            <div class="files-list">
                                @foreach ($materials as $material)
                                    <a href="{{ display_file($material->file) }}" target="_blank" rel="noopener"
                                        class="file-item">
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
                        @if ($prevLecture)
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
                        @if ($nextLecture)
                            <a href="{{ route('front.courses.lesson', [$subject, $nextLecture]) }}"
                                class="nav-lesson-btn next">
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
                    @foreach ($lectures as $idx => $lec)
                        @php
                            $isActive = $lec->id === $lecture->id;
                            $isPast = $idx < $currentIndex;
                            $isLocked = $idx > $currentIndex;
                        @endphp
                        @if ($isActive)
                            <div class="playlist-item active">
                                <div class="pl-num pl-num-active">▶</div>
                                <div class="pl-info">
                                    <div class="pl-title">{{ $lec->title }}</div>
                                    <div class="pl-meta">{{ $lec->materials_count ?? 0 }} مادة @if ($assessment && $lec->id === $lecture->id)
                                            • ١ تقييم
                                        @endif
                                    </div>
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

                @if ($assessment)
                    <div class="sidebar-section">
                        <div class="sidebar-title">تقييمات المادة</div>
                        <div class="quiz-card">
                            <div class="quiz-card-title">🧪 {{ $assessment->title }}</div>
                            <div class="quiz-info-row">
                                <span class="quiz-info-text">عدد الأسئلة:
                                    {{ $assessment->questions_count ?? $assessment->questions()->count() }}</span>
                                @if ($hasAssessmentResult)
                                    <span class="quiz-done-badge">✓ تم الحل مسبقاً</span>
                                @endif
                            </div>
                            @if ($hasAssessmentResult)
                                <a href="{{ route('front.assessments.review', $assessment) }}" class="btn-quiz-view">عرض
                                    التقييم ←</a>
                            @else
                                <a href="{{ route('front.assessments.show', $assessment) }}" class="btn-quiz-view">بدء
                                    التقييم ←</a>
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
                            <div class="course-sidebar-path">{{ $grade?->name ?? '—' }} — {{ $stage?->name ?? '—' }}
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('front.courses.subject', $subject) }}" class="btn-back-course">← الرجوع لصفحة
                        الكورس</a>
                </div>
            </aside>
        </div>
    </div>

    @if ($videoId)
        @push('scripts')
            <script>
                (function() {
                    var placeholder = document.getElementById('videoPlaceholder');
                    var markDoneBtn = document.getElementById('markDoneBtn');
                    if (!placeholder) return;

                    var videoId = placeholder.getAttribute('data-video-id');
                    var resumeSeconds = parseInt(placeholder.getAttribute('data-resume'), 10) || 0;
                    var progressUrl = {!! json_encode(route('front.courses.progress', [$subject, $lecture])) !!};
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var player = null;
                    var saveTimer = null;

                    function sendProgress(position, duration, completed, useBeacon) {
                        var payload = {
                            position: Math.max(0, Math.round(position || 0)),
                            duration: duration ? Math.round(duration) : null,
                            completed: !!completed,
                            _token: csrfToken
                        };
                        if (useBeacon && navigator.sendBeacon) {
                            var blob = new Blob([JSON.stringify(payload)], {
                                type: 'application/json'
                            });
                            navigator.sendBeacon(progressUrl, blob);
                            return;
                        }
                        fetch(progressUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload),
                            keepalive: true
                        }).catch(function() {});
                    }

                    function startAutoSave() {
                        stopAutoSave();
                        saveTimer = setInterval(function() {
                            if (!player || typeof player.getCurrentTime !== 'function') return;
                            sendProgress(player.getCurrentTime(), player.getDuration());
                        }, 5000);
                    }

                    function stopAutoSave() {
                        if (saveTimer) {
                            clearInterval(saveTimer);
                            saveTimer = null;
                        }
                    }

                    function onPlayerStateChange(e) {
                        if (e.data === YT.PlayerState.PLAYING) {
                            startAutoSave();
                        } else if (e.data === YT.PlayerState.PAUSED) {
                            stopAutoSave();
                            sendProgress(player.getCurrentTime(), player.getDuration());
                        } else if (e.data === YT.PlayerState.ENDED) {
                            stopAutoSave();
                            sendProgress(player.getDuration(), player.getDuration(), true);
                            if (markDoneBtn) {
                                markDoneBtn.textContent = '✅ تمت المشاهدة';
                                markDoneBtn.setAttribute('data-completed', '1');
                            }
                        }
                    }

                    function createPlayer() {
                        player = new YT.Player('ytPlayer', {
                            videoId: videoId,
                            playerVars: {
                                autoplay: 1,
                                rel: 0,
                                modestbranding: 1,
                                start: resumeSeconds
                            },
                            events: {
                                onStateChange: onPlayerStateChange
                            }
                        });
                    }

                    function launchPlayer() {
                        placeholder.style.display = 'none';
                        document.getElementById('ytPlayer').style.display = 'block';
                        if (window.YT && window.YT.Player) {
                            createPlayer();
                        } else {
                            window.onYouTubeIframeAPIReady = createPlayer;
                            var tag = document.createElement('script');
                            tag.src = 'https://www.youtube.com/iframe_api';
                            document.body.appendChild(tag);
                        }
                    }

                    placeholder.addEventListener('click', launchPlayer);

                    if (markDoneBtn) {
                        markDoneBtn.addEventListener('click', function() {
                            var position = (player && typeof player.getCurrentTime === 'function') ? player
                                .getCurrentTime() : resumeSeconds;
                            var duration = (player && typeof player.getDuration === 'function') ? player.getDuration() :
                                null;
                            sendProgress(position, duration, true);
                            markDoneBtn.textContent = '✅ تمت المشاهدة';
                            markDoneBtn.setAttribute('data-completed', '1');
                        });
                    }

                    function sendFinalUpdate() {
                        if (!player || typeof player.getCurrentTime !== 'function') return;
                        sendProgress(player.getCurrentTime(), player.getDuration(), false, true);
                    }

                    window.addEventListener('beforeunload', sendFinalUpdate);
                    document.addEventListener('visibilitychange', function() {
                        if (document.visibilityState === 'hidden') sendFinalUpdate();
                    });
                })();
            </script>
        @endpush
    @endif
@endsection
