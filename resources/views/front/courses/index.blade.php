@extends('front.layouts.front', ['title' => 'فاهم — الكورسات'])

@section('content')
{{-- Hero Band --}}
<div class="hero-band">
    <div class="hero-inner">
        <div class="hero-eyebrow">📚 كل الكورسات المتاحة</div>
        <h1>تعلّم بذكاء،<br/><em>اختر مسارك الدراسي</em></h1>
        <p>اختر مرحلتك الدراسية ثم الصف والمادة لتبدأ التعلّم مع أفضل الكورسات التفاعلية.</p>
    </div>
</div>

@php
    $stages = $stages ?? collect();
    $firstStageId = $stages->first()?->id;
@endphp

{{-- Stage Tabs --}}
@if($stages->isNotEmpty())
<div class="stage-filter-wrap">
    <div class="stage-tabs">
        @foreach($stages as $stage)
            @php $stageCount = $stage->grades->sum(fn($g) => $g->subjects->count()); @endphp
            <button type="button" class="stage-tab {{ $loop->first ? 'active' : '' }}" data-stage-id="{{ $stage->id }}" onclick="setStage({{ $stage->id }}, this)">
                {{ $stage->name }} <span class="tab-badge">{{ $stageCount }}</span>
            </button>
        @endforeach
    </div>
</div>
@endif

{{-- Page Layout: Sidebar + Content --}}
<div class="page-layout">
    {{-- Sidebar: الصفوف والمواد (per stage) --}}
    <aside class="sidebar">
        <div class="sidebar-title">الصفوف والمواد</div>
        @foreach($stages as $stage)
            <div id="sidebar-stage-{{ $stage->id }}" class="sidebar-stage" style="display: {{ $loop->first ? 'block' : 'none' }};">
                @foreach($stage->grades as $grade)
                    @if($grade->subjects->count() > 0)
                    <div class="grade-item">
                        <button type="button" class="grade-toggle {{ $loop->first ? 'active' : '' }}" onclick="toggleGrade(this)">
                            {{ $grade->name }} <span class="grade-arrow">›</span>
                        </button>
                        <div class="grade-subjects">
                            <button type="button" class="subject-btn {{ $loop->parent->first && $loop->first ? 'active' : '' }}" data-grade-id="{{ $grade->id }}" data-subject-id="all" onclick="filterSubject({{ $grade->id }}, 'all', this)">
                                <div class="subject-icon" style="background:#EFF6FF;">📚</div> كل المواد
                            </button>
                            @foreach($grade->subjects as $subject)
                                <button type="button" class="subject-btn" data-grade-id="{{ $grade->id }}" data-subject-id="{{ $subject->id }}" onclick="filterSubject({{ $grade->id }}, {{ $subject->id }}, this)">
                                    <div class="subject-icon" style="background:#EFF6FF;">📖</div> {{ $subject->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </aside>

    {{-- Content --}}
    <main class="content-area" id="mainContent">
        @forelse($stages as $stage)
            <div id="stage-content-{{ $stage->id }}" class="stage-content" data-stage-id="{{ $stage->id }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                @php $hasAny = false; @endphp
                @foreach($stage->grades as $grade)
                    @if($grade->subjects->count() > 0)
                        @php $hasAny = true; @endphp
                        @if($loop->first)
                        <div class="section-header">
                            <div class="section-title-group">
                                <div class="section-label">{{ $grade->name }}</div>
                                <div class="section-title">{{ $stage->name }}</div>
                            </div>
                            <div class="courses-count">{{ $grade->subjects->count() }} كورس</div>
                        </div>
                        @else
                        <div class="grade-divider">
                            <div class="grade-divider-text">{{ $grade->name }}</div>
                            <div class="grade-divider-line"></div>
                            <div class="courses-count" style="flex-shrink:0;">{{ $grade->subjects->count() }} كورس</div>
                        </div>
                        @endif

                        <div class="courses-grid" id="grid-stage-{{ $stage->id }}-grade-{{ $grade->id }}" data-grade-id="{{ $grade->id }}">
                            @foreach($grade->subjects as $subject)
                                @php
                                    $name = $subject->name;
                                    $slug = 'physics';
                                    if (str_contains($name, 'عربي') || str_contains($name, 'عرب')) $slug = 'arabic';
                                    elseif (str_contains($name, 'رياض')) $slug = 'math';
                                    elseif (str_contains($name, 'علوم')) $slug = 'science';
                                    elseif (str_contains($name, 'إنجليز') || str_contains($name, 'انجليز')) $slug = 'english';
                                    elseif (str_contains($name, 'اجتماع') || str_contains($name, 'جغر') || str_contains($name, 'دراسات')) $slug = 'social';
                                @endphp
                                <a href="{{ route('front.courses.subject', $subject) }}" class="course-card" data-stage-id="{{ $stage->id }}" data-grade-id="{{ $grade->id }}" data-subject-id="{{ $subject->id }}">
                                    <div class="card-thumb thumb-{{ $slug }} position-relative">
                                        @auth
                                            @if(auth()->user()->type === 'student')
                                            <div class="favorite-btn-wrap position-absolute top-0 start-0 m-2">
                                                @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                                            </div>
                                            @endif
                                        @endauth
                                        <span class="card-subject-tag tag-{{ $slug }}">{{ $subject->name }}</span>
                                        @if($subject->image)
                                            <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <span>📖</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="card-subject">{{ $subject->name }} — {{ $grade->name }}</div>
                                        <div class="card-title">{{ $subject->name }} {{ $grade->name }}</div>
                                        <div class="card-meta">كورس كامل يغطي منهج المادة مع حصص فيديو واختبارات تفاعلية.</div>
                                        <div class="card-tags">
                                            <span class="tag">📹 فيديو</span>
                                            <span class="tag">✅ اختبارات</span>
                                        </div>
                                        <div class="card-footer">
                                            <div class="card-stats">
                                                <div class="card-stat">👥 <span>طالب</span></div>
                                                <div class="card-stat">⭐ <span>—</span></div>
                                            </div>
                                            @auth
                                                @if(in_array($subject->id, $subscribedSubjectIds ?? []))
                                                    <span class="badge badge-subscribed rounded-pill">مشترك</span>
                                                @else
                                                    <span class="btn-card">عرض الكورس</span>
                                                @endif
                                            @else
                                                <span class="btn-card">عرض الكورس</span>
                                            @endauth
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endforeach

                @if(!$hasAny)
                    <div class="empty-state show">
                        <div class="empty-icon">🚀</div>
                        <div class="empty-text">قريباً — سيتم إضافة كورسات لهذه المرحلة</div>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state show">
                <div class="empty-icon">📚</div>
                <div class="empty-text">لا توجد مراحل أو كورسات متاحة حالياً.</div>
            </div>
        @endforelse
    </main>
</div>

<script>
function setStage(stageId, btn) {
    document.querySelectorAll('.stage-tab').forEach(function(t) { t.classList.remove('active'); });
    if (btn) btn.classList.add('active');
    document.querySelectorAll('.stage-content').forEach(function(el) {
        el.style.display = el.dataset.stageId === String(stageId) ? 'block' : 'none';
    });
    document.querySelectorAll('.sidebar-stage').forEach(function(el) {
        el.style.display = el.id === 'sidebar-stage-' + stageId ? 'block' : 'none';
    });
    // Reset first grade active in this stage's sidebar
    var sidebar = document.getElementById('sidebar-stage-' + stageId);
    if (sidebar) {
        sidebar.querySelectorAll('.grade-toggle').forEach(function(g, i) { g.classList.toggle('active', i === 0); });
        sidebar.querySelectorAll('.grade-toggle.active + .grade-subjects').forEach(function(s) { s.style.display = 'block'; });
        sidebar.querySelectorAll('.grade-toggle:not(.active) + .grade-subjects').forEach(function(s) { s.style.display = 'none'; });
        sidebar.querySelectorAll('.subject-btn').forEach(function(s, i) {
            var firstGrade = sidebar.querySelector('.grade-item');
            s.classList.toggle('active', firstGrade && s.closest('.grade-subjects') === firstGrade.querySelector('.grade-subjects') && s.dataset.subjectId === 'all');
        });
    }
    filterSubject(null, 'all', null);
}

function toggleGrade(btn) {
    var parent = btn.closest('.sidebar-stage');
    if (!parent) return;
    parent.querySelectorAll('.grade-toggle').forEach(function(g) { if (g !== btn) g.classList.remove('active'); });
    btn.classList.toggle('active');
}

function filterSubject(gradeId, subjectId, btn) {
    if (btn) {
        var stageContent = document.querySelector('.stage-content[style*="block"]') || document.querySelector('.stage-content');
        var stageId = stageContent ? stageContent.dataset.stageId : null;
        var sidebar = stageId ? document.getElementById('sidebar-stage-' + stageId) : null;
        if (sidebar) {
            sidebar.querySelectorAll('.subject-btn').forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
        }
    }
    var stageContent = document.querySelector('.stage-content[style*="block"]') || document.querySelector('.stage-content');
    var stageId = stageContent ? stageContent.dataset.stageId : null;
    document.querySelectorAll('.course-card').forEach(function(card) {
        if (card.dataset.stageId !== stageId) { card.style.display = 'none'; return; }
        var matchGrade = !gradeId || card.dataset.gradeId === String(gradeId);
        var matchSubject = subjectId === 'all' || card.dataset.subjectId === String(subjectId);
        card.style.display = (matchGrade && matchSubject) ? '' : 'none';
    });
}
</script>
@endsection
