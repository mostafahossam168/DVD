@extends('front.layouts.front', ['title' => 'المواد الدراسية'])

@section('content')
@php
    $themes = ['theme-blue', 'theme-purple', 'theme-teal', 'theme-green', 'theme-orange', 'theme-rose'];
    $icons = ['📝', '⚛️', '🌍', '📐', '🔬', '🏛️'];
    // استخراج فلتر المرحلة من اسم المرحلة
    $getFilter = function ($subject) {
        $stageName = $subject->grade && $subject->grade->stage ? $subject->grade->stage->name : '';
        if (str_contains($stageName, 'بكالوريا')) return 'بكالوريا';
        if (str_contains($stageName, 'ثانوي')) return 'ثانوي';
        if (str_contains($stageName, 'اعداد')) return 'اعدادي';
        return '';
    };
@endphp
<div class="subj-hero hero-subjects">
    <div class="subj-hero-inner">
        <div>
            <h1>المواد الدراسية</h1>
            <p class="subj-hero-desc">استعرض جميع المواد المتاحة عبر المراحل الدراسية المختلفة</p>
            <div class="hero-pills">
                <div class="hero-pill {{ ($activeStage ?? 'الكل') === 'الكل' ? 'active' : '' }}" data-filter="الكل">الكل</div>
                <div class="hero-pill {{ ($activeStage ?? 'الكل') === 'اعدادي' ? 'active' : '' }}" data-filter="اعدادي">اعدادي</div>
                <div class="hero-pill {{ ($activeStage ?? 'الكل') === 'ثانوي' ? 'active' : '' }}" data-filter="ثانوي">ثانوي</div>
                <div class="hero-pill {{ ($activeStage ?? 'الكل') === 'بكالوريا' ? 'active' : '' }}" data-filter="بكالوريا">بكالوريا</div>
            </div>
        </div>
        <div class="hero-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,.7)" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" placeholder="ابحث عن مادة دراسية..." id="subj-search">
        </div>
    </div>
</div>

<div class="subj-wrap">
    <div class="subj-grid" id="subj-grid">
        @forelse ($subjects ?? [] as $index => $subject)
            @php
                $theme = $themes[$index % count($themes)];
                $icon = $icons[$index % count($icons)];
                $filterVal = $getFilter($subject);
            @endphp
            <a href="{{ route('front.courses.subject', $subject) }}" class="subj-card {{ $theme }} subj-card-item"
               data-filter="{{ $filterVal }}"
               data-name="{{ $subject->name }}">
                <div class="subj-card-fav" onclick="event.preventDefault(); event.stopPropagation();">
                    @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                </div>
                <div class="subj-thumb">
                    @if ($subject->image)
                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="subj-thumb-img">
                    @endif
                    @if (!$subject->image)
                        <div class="bg-text">{{ Str::limit($subject->name, 2, '') }}</div>
                        <div class="subject-icon">{{ $icon }}</div>
                    @endif
                    @if ($filterVal)
                        <div class="badge">{{ $filterVal }}</div>
                    @elseif ($subject->grade && $subject->grade->stage)
                        <div class="badge">{{ $subject->grade->stage->name }}</div>
                    @endif
                </div>
                <div class="subj-body">
                    <div class="subj-name">{{ $subject->name }}</div>
                    <div class="subj-meta">
                        @if ($subject->grade)
                            {{ $subject->grade->name }} - {{ $subject->grade->stage?->name ?? '' }}
                        @else
                            —
                        @endif
                    </div>
                    <div class="subj-desc">كورس كامل منهج المادة مع حصص فيديو واختبارات.</div>
                    @if($subject->price !== null)
                        <div class="subj-price">{{ number_format($subject->price, 0) }} ج.م</div>
                    @endif
                    <div class="subj-stats">
                        <span class="subj-stat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10l4.553-2.069A1 1 0 0 1 21 8.845v6.31a1 1 0 0 1-1.447.894L15 14M3 8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            24 فيديو
                        </span>
                        <span class="subj-stat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            8 اختبارات
                        </span>
                        <span class="subj-stat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            +1200 طالب
                        </span>
                    </div>
                </div>
                <div class="subj-footer">
                    <span class="btn-view">عرض الكورس</span>
                </div>
            </a>
        @empty
            <p class="text-muted">لا توجد مواد حالياً.</p>
        @endforelse
    </div>
</div>

@if (count($subjects ?? []) > 0)
<script>
(function(){
  var pills = document.querySelectorAll('.hero-pill');
  var cards = document.querySelectorAll('.subj-card-item');
  var searchInput = document.getElementById('subj-search');
  function applyFilter() {
    var filter = document.querySelector('.hero-pill.active');
    var f = filter ? filter.getAttribute('data-filter') : 'الكل';
    var q = (searchInput && searchInput.value) ? searchInput.value.trim().toLowerCase() : '';
    cards.forEach(function(card){
      var showByFilter = f === 'الكل' || (card.getAttribute('data-filter') || '') === f;
      var showBySearch = !q || (card.getAttribute('data-name') || '').toLowerCase().indexOf(q) !== -1;
      card.style.display = (showByFilter && showBySearch) ? '' : 'none';
    });
  }
  pills.forEach(function(p){ p.addEventListener('click', function(){ pills.forEach(function(x){ x.classList.remove('active'); }); p.classList.add('active'); applyFilter(); }); });
  if (searchInput) searchInput.addEventListener('input', applyFilter);
  applyFilter();
})();
</script>
@endif
@endsection
