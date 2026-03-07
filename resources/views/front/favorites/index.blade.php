@extends('front.layouts.front', ['title' => 'فاهم — المفضلة'])

@section('content')
@php
    $subjects = $subjects ?? collect();
    $stagesCount = $stagesCount ?? 0;
    $subjectNamesForFilter = $subjectNamesForFilter ?? [];
    $total = $subjects->count();
    $slugFromName = function ($name) {
        if (str_contains($name ?? '', 'عربي') || str_contains($name ?? '', 'عرب')) return 'arabic';
        if (str_contains($name ?? '', 'رياض')) return 'math';
        if (str_contains($name ?? '', 'علوم')) return 'science';
        if (str_contains($name ?? '', 'إنجليز') || str_contains($name ?? '', 'انجليز')) return 'english';
        if (str_contains($name ?? '', 'اجتماع') || str_contains($name ?? '', 'جغر') || str_contains($name ?? '', 'دراسات')) return 'social';
        return 'physics';
    };
@endphp

<div class="favorites-hero">
    <div class="hero-band">
        <div class="hero-inner">
            <div class="hero-text">
                <div class="hero-eyebrow">❤️ المفضلة</div>
                <h1>الكورسات <em>المفضلة</em></h1>
                <p class="hero-sub">الكورسات التي أضفتها للمفضلة — ارجع إليها في أي وقت.</p>
            </div>
            @if($total > 0)
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-val" id="statTotal">{{ $total }}</div>
                    <div class="hero-stat-label">في المفضلة</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-val">{{ $stagesCount }}</div>
                    <div class="hero-stat-label">مرحلة مختلفة</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($total > 0)
{{-- Filter bar --}}
<div class="filter-bar">
    <div class="filter-inner">
        <div class="filter-tabs">
            <button type="button" class="filter-tab active" data-filter="all">الكل</button>
            @foreach($subjectNamesForFilter as $name)
                <button type="button" class="filter-tab" data-filter="{{ e($name) }}">{{ $name }}</button>
            @endforeach
        </div>
        <div class="filter-right">
            <select class="sort-select" id="sortSelect">
                <option value="default">الترتيب الافتراضي</option>
                <option value="name">حسب الاسم</option>
            </select>
            <div class="view-btns">
                <button type="button" class="view-btn active" id="gridViewBtn" title="عرض شبكة">⊞</button>
                <button type="button" class="view-btn" id="listViewBtn" title="عرض قائمة">☰</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="page-content" style="padding:32px 5% 80px">
    <div class="courses-grid" id="coursesGrid" style="{{ $total === 0 ? 'display:none' : '' }}">
        @foreach($subjects as $subject)
            @php
                $grade = $subject->grade;
                $stage = $grade?->stage;
                $slug = $slugFromName($subject->name);
            @endphp
            <div class="course-card" data-subject-name="{{ e($subject->name) }}" data-name="{{ e($subject->name) }}">
                <a href="{{ route('front.courses.subject', $subject) }}" style="text-decoration:none;color:inherit;display:flex;flex-direction:column;flex:1">
                    <div class="card-thumb thumb-{{ $slug }} position-relative">
                        @if($subject->image)
                            <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <span>📖</span>
                        @endif
                        <button type="button" class="fav-btn" title="إزالة من المفضلة" onclick="favRemoveClick(event, this)">❤️</button>
                        <span class="subject-tag tag-{{ $slug }}">{{ $subject->name }}</span>
                        <div class="remove-confirm" id="confirm-{{ $subject->id }}">
                            إزالة من المفضلة؟<br/>
                            <span class="remove-link" data-subject-id="{{ $subject->id }}" data-toggle-url="{{ route('front.favorites.toggle', $subject) }}">نعم، إزالة</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-subject">{{ $subject->name }}</div>
                        <div class="card-title">{{ $subject->name }}</div>
                        <div class="card-meta">{{ $grade?->name ?? '—' }} — {{ $stage?->name ?? '—' }}</div>
                        @if($subject->price !== null)
                            <div class="card-price">{{ number_format($subject->price, 0) }} ج.م</div>
                        @endif
                        <div class="card-tags">
                            <span class="tag">📹 فيديو</span>
                            <span class="tag">✅ اختبارات</span>
                        </div>
                        <div class="card-footer">
                            <div>
                                <div class="card-rating">⭐ —</div>
                                <div class="card-students">👥 —</div>
                            </div>
                            <span class="btn-view">عرض الكورس</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="empty-state {{ $total === 0 ? 'show' : '' }}" id="emptyState">
        <div class="empty-icon">💔</div>
        <div class="empty-title">لا توجد كورسات في المفضلة</div>
        <div class="empty-sub">لم تضف أي كورسات للمفضلة بعد.<br/>استكشف الكورسات وأضف ما يعجبك!</div>
        <a href="{{ route('front.courses.index') }}" class="btn-browse">استكشف الكورسات</a>
    </div>
</div>

@push('scripts')
<script>
(function() {
  var grid = document.getElementById('coursesGrid');
  var emptyState = document.getElementById('emptyState');
  var statTotal = document.getElementById('statTotal');

  function toArabic(n) {
    return String(n).replace(/\d/g, function(d) { return '٠١٢٣٤٥٦٧٨٩'[d]; });
  }

  function updateCount() {
    var cards = grid ? grid.querySelectorAll('.course-card:not([style*="display:none"])') : [];
    var visible = cards.length;
    if (statTotal) statTotal.textContent = toArabic(visible);
  }

  function checkEmpty() {
    var cards = grid ? grid.querySelectorAll('.course-card') : [];
    if (emptyState) emptyState.classList.toggle('show', cards.length === 0);
    if (grid) grid.style.display = cards.length ? '' : 'none';
  }

  window.favRemoveClick = function(ev, btn) {
    ev.preventDefault();
    ev.stopPropagation();
    var tip = btn.parentElement.querySelector('.remove-confirm');
    if (tip) {
      tip.classList.add('show');
      setTimeout(function() { tip.classList.remove('show'); }, 3000);
    }
  };

  document.addEventListener('click', function(e) {
    var removeLink = e.target.closest('.remove-link');
    if (!removeLink) return;
    e.preventDefault();
    e.stopPropagation();
    var url = removeLink.getAttribute('data-toggle-url');
    var card = removeLink.closest('.course-card');
    if (!url || !card) return;
    var formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    fetch(url, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        if (data.success) {
          card.style.animation = 'favFadeOut 0.3s ease forwards';
          setTimeout(function() {
            card.remove();
            updateCount();
            checkEmpty();
          }, 280);
        }
      });
  });

  var filterTabs = document.querySelectorAll('.filter-tab');
  filterTabs.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterTabs.forEach(function(t) { t.classList.remove('active'); });
      btn.classList.add('active');
      var val = btn.getAttribute('data-filter');
      grid.querySelectorAll('.course-card').forEach(function(card) {
        var show = val === 'all' || card.getAttribute('data-subject-name') === val;
        card.style.display = show ? '' : 'none';
      });
      updateCount();
    });
  });

  document.getElementById('sortSelect') && document.getElementById('sortSelect').addEventListener('change', function() {
    var by = this.value;
    var cards = Array.from(grid.querySelectorAll('.course-card'));
    if (by === 'name') cards.sort(function(a, b) { return (a.getAttribute('data-name') || '').localeCompare(b.getAttribute('data-name') || '', 'ar'); });
    cards.forEach(function(c) { grid.appendChild(c); });
  });

  document.getElementById('gridViewBtn') && document.getElementById('gridViewBtn').addEventListener('click', function() {
    grid.classList.remove('list-view');
    document.getElementById('gridViewBtn').classList.add('active');
    document.getElementById('listViewBtn').classList.remove('active');
  });
  document.getElementById('listViewBtn') && document.getElementById('listViewBtn').addEventListener('click', function() {
    grid.classList.add('list-view');
    document.getElementById('listViewBtn').classList.add('active');
    document.getElementById('gridViewBtn').classList.remove('active');
  });

  var style = document.createElement('style');
  style.textContent = '@keyframes favFadeOut{from{opacity:1;transform:scale(1)}to{opacity:0;transform:scale(0.95)}}';
  document.head.appendChild(style);

  checkEmpty();
})();
</script>
@endpush
@endsection
