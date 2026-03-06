@extends('front.layouts.front', ['title' => 'فاهم — اختباراتي'])

@section('content')
@php
    $stats = $stats ?? ['total' => 0, 'passed' => 0, 'failed' => 0, 'zero' => 0, 'avg_pct' => 0];
    $slugFromName = function ($name) {
        if (str_contains($name ?? '', 'عربي') || str_contains($name ?? '', 'عرب')) return 'arabic';
        if (str_contains($name ?? '', 'رياض')) return 'math';
        if (str_contains($name ?? '', 'علوم')) return 'science';
        if (str_contains($name ?? '', 'إنجليز') || str_contains($name ?? '', 'انجليز')) return 'english';
        if (str_contains($name ?? '', 'اجتماع') || str_contains($name ?? '', 'جغر') || str_contains($name ?? '', 'دراسات')) return 'social';
        return 'physics';
    };
    $subjBg = [
        'arabic' => 'linear-gradient(135deg,#FFF7ED,#FED7AA)',
        'math' => 'linear-gradient(135deg,#F0FDF4,#BBF7D0)',
        'science' => 'linear-gradient(135deg,#F0F9FF,#BAE6FD)',
        'english' => 'linear-gradient(135deg,#FDF4FF,#E9D5FF)',
        'social' => 'linear-gradient(135deg,#EFF6FF,#BFDBFE)',
        'physics' => 'linear-gradient(135deg,#EFF6FF,#DBEAFE)',
    ];
@endphp

<div class="quizzes-hero">
    <div class="hero-band">
        <div class="hero-inner">
            <div>
                <div class="hero-eyebrow">📝 اختباراتي</div>
                <h1 class="hero-title">الاختبارات التي <em>قمت بحلّها</em></h1>
                <p class="hero-sub">سجل كامل باختباراتك ودرجاتك ونتائجك.</p>
            </div>
            <div class="hero-cards">
                <div class="hero-stat-card">
                    <div class="hsc-val" id="statTotal">{{ $stats['total'] }}</div>
                    <div class="hsc-label">إجمالي الاختبارات</div>
                </div>
                <div class="hero-stat-card">
                    <div class="hsc-val" style="color:#6EE7B7" id="statPassed">{{ $stats['passed'] }}</div>
                    <div class="hsc-label">ناجح</div>
                </div>
                <div class="hero-stat-card">
                    <div class="hsc-val" style="color:#FCA5A5" id="statFailed">{{ $stats['failed'] }}</div>
                    <div class="hsc-label">راسب</div>
                </div>
                <div class="hero-stat-card">
                    <div class="hsc-val" id="statAvgPct">{{ $stats['avg_pct'] }}٪</div>
                    <div class="hsc-label">متوسط الدرجات</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($results->count() > 0)
<div class="filter-bar quizzes-filter-bar">
    <div class="filter-inner">
        <div class="filter-tabs">
            <button type="button" class="filter-tab active" data-filter="all">الكل</button>
            <button type="button" class="filter-tab" data-filter="pass">✅ ناجح</button>
            <button type="button" class="filter-tab" data-filter="fail">❌ راسب</button>
            <button type="button" class="filter-tab" data-filter="zero">⏳ لم يُصحَّح</button>
        </div>
        <div class="search-input-wrap">
            <span class="si">🔍</span>
            <input type="text" placeholder="ابحث باسم الاختبار..." id="quizSearchInput"/>
        </div>
    </div>
</div>
@endif

<div class="quizzes-page-wrap">
    <div class="quizzes-table-card">
        <div class="quizzes-table-header">
            <div class="quizzes-table-title">📋 سجل الاختبارات <span class="quizzes-table-count" id="rowCount">٠ اختبار</span></div>
        </div>

        @if($results->count() > 0)
        <table class="quizzes-table" id="quizTable">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th>الاختبار</th>
                    <th>المادة</th>
                    <th class="center">الدرجة</th>
                    <th class="center">النتيجة</th>
                    <th>تاريخ الحل</th>
                    <th class="center">مراجعة</th>
                </tr>
            </thead>
            <tbody id="quizBody">
                @foreach($results as $index => $result)
                    @php
                        $quiz = $result->quiz;
                        $subject = $quiz?->lecture?->subject;
                        $grade = $subject?->grade;
                        $stage = $grade?->stage;
                        $maxScore = $result->max_score;
                        $score = $result->score;
                        $pct = $maxScore > 0 ? round($score / $maxScore * 100) : 0;
                        $resultType = $score == 0 ? 'zero' : ($pct >= 50 ? 'pass' : 'fail');
                        $slug = $subject ? $slugFromName($subject->name) : 'physics';
                        $subjBgStyle = $subjBg[$slug] ?? $subjBg['physics'];
                        $quizTitle = $quiz?->title ?? '—';
                    @endphp
                    <tr data-result="{{ $resultType }}" data-name="{{ e($quizTitle) }}">
                        <td class="num">{{ $results->firstItem() + $index }}</td>
                        <td>
                            @if($quiz)
                                <a href="{{ route('front.quizzes.review', $quiz) }}" class="quiz-link">{{ $quiz->title }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($subject)
                            <div class="subject-cell">
                                <div class="subj-icon" style="background:{{ $subjBgStyle }}">📖</div>
                                <div>
                                    <div class="subj-name">{{ $subject->name }}</div>
                                    <div class="subj-path">{{ $grade?->name ?? '—' }} — {{ $stage?->name ?? '—' }}</div>
                                </div>
                            </div>
                            @else
                                —
                            @endif
                        </td>
                        <td class="center">
                            <div class="score-cell">
                                <div class="score-fraction {{ $resultType }}">{{ $score }} / {{ $maxScore }}</div>
                                <div class="score-bar-wrap"><div class="score-bar-fill fill-{{ $resultType }}" style="width:{{ $pct }}%"></div></div>
                                <div class="score-pct">{{ $pct }}٪</div>
                            </div>
                        </td>
                        <td class="center">
                            @if($resultType === 'pass')
                                <span class="result-chip chip-pass">✅ ناجح</span>
                            @elseif($resultType === 'fail')
                                <span class="result-chip chip-fail">❌ راسب</span>
                            @else
                                <span class="result-chip chip-zero">⏳ قيد التصحيح</span>
                            @endif
                        </td>
                        <td>
                            <div class="date-cell">{{ $result->created_at->format('Y-m-d') }}</div>
                            <div class="date-relative">{{ $result->created_at->format('H:i') }}</div>
                        </td>
                        <td class="center">
                            @if($quiz)
                                <a href="{{ route('front.quizzes.review', $quiz) }}" class="action-btn review">👁 مراجعة</a>
                            @else
                                <span class="action-btn">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="quizzes-empty-state" id="emptyState">
            <div class="empty-icon">📋</div>
            <div class="empty-title">لا توجد نتائج</div>
            <div class="empty-sub">لا يوجد اختبارات تطابق الفلتر المحدد.</div>
        </div>

        @if($results->hasPages())
        <div style="padding:16px 24px; border-top:1px solid var(--border);">
            {{ $results->links() }}
        </div>
        @endif
        @else
        <div class="quizzes-empty-state show">
            <div class="empty-icon">📋</div>
            <div class="empty-title">لا توجد اختبارات بعد</div>
            <div class="empty-sub">لم تقم بحل أي اختبارات بعد. ادخل إلى كورسك وابدأ بحل الاختبارات!</div>
            <a href="{{ route('front.courses.index') }}" class="btn-browse" style="margin-top:16px">استكشف الكورسات</a>
        </div>
        @endif
    </div>
</div>

@if($results->count() > 0)
@push('scripts')
<script>
(function() {
  var body = document.getElementById('quizBody');
  var rows = body ? body.querySelectorAll('tr') : [];
  var rowCountEl = document.getElementById('rowCount');
  var emptyState = document.getElementById('emptyState');
  var filterTabs = document.querySelectorAll('.quizzes-filter-bar .filter-tab');
  var searchInput = document.getElementById('quizSearchInput');

  function toArabic(n) {
    return String(n).replace(/\d/g, function(d) { return '٠١٢٣٤٥٦٧٨٩'[d]; });
  }

  function updateCount(visible) {
    if (rowCountEl) rowCountEl.textContent = toArabic(visible) + ' اختبار';
  }

  function applyFilterAndSearch() {
    var filter = document.querySelector('.quizzes-filter-bar .filter-tab.active');
    var filterVal = filter ? filter.getAttribute('data-filter') : 'all';
    var q = (searchInput && searchInput.value.trim()) ? searchInput.value.trim().toLowerCase() : '';
    var visible = 0;
    rows.forEach(function(r) {
      var showResult = filterVal === 'all' || r.getAttribute('data-result') === filterVal;
      var name = (r.getAttribute('data-name') || '').toLowerCase();
      var showSearch = !q || name.indexOf(q) !== -1;
      var show = showResult && showSearch;
      r.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    updateCount(visible);
    if (emptyState) emptyState.classList.toggle('show', visible === 0);
  }

  filterTabs.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterTabs.forEach(function(t) { t.classList.remove('active'); });
      btn.classList.add('active');
      applyFilterAndSearch();
    });
  });

  if (searchInput) searchInput.addEventListener('input', applyFilterAndSearch);

  applyFilterAndSearch();
})();
</script>
@endpush
@endif
@endsection
