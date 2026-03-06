@extends('front.layouts.front', ['title' => $stage->name])

@section('content')
@php
  $grades = $stage->grades;
  $totalSubjects = $grades->sum(fn($g) => $g->subjects_count ?? $g->subjects->count() ?? 0);
  $gradeIcons = ['📖', '📝', '🎯', '📐', '🔬', '📚'];
@endphp

<div class="stage-detail-hero">
  <div class="hero-inner">
    <div class="hero-breadcrumb">
      <a href="{{ route('front.stages.index') }}">المراحل الدراسية</a>
      <span class="sep">›</span>
      <span style="opacity:1;font-weight:700">{{ $stage->name }}</span>
    </div>
    <h1>{{ $stage->name }}</h1>
    <p class="hero-desc">أساس تعليمي قوي بأسلوب سهل يناسب كل طالب. مع امتحانات ومتابعة مستمرة.</p>
    <a href="#grades-section" class="hero-btn">
      ابدأ الآن
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
    </a>
    <div class="hero-stats">
      <div class="hero-stat"><div class="num">{{ $grades->count() }}</div><div class="lbl">صفوف دراسية</div></div>
      <div class="hero-stat"><div class="num">+{{ $totalSubjects }}</div><div class="lbl">كورس متاح</div></div>
      <div class="hero-stat"><div class="num">4.9★</div><div class="lbl">تقييم الطلاب</div></div>
      <div class="hero-stat"><div class="num">+5000</div><div class="lbl">طالب مسجل</div></div>
    </div>
  </div>
</div>

<section class="grades-section" id="grades-section">
  <div class="section-header">
    <h2>اختر صفك الدراسي</h2>
    <p>كل صف فيه محتوى مخصص ومواد شاملة</p>
  </div>
  <div class="grades-grid">
    @forelse ($grades as $idx => $grade)
      @php
        $subCount = $grade->subjects_count ?? $grade->subjects->count() ?? 0;
        $icon = $gradeIcons[$idx % count($gradeIcons)];
      @endphp
      <a href="{{ route('front.grades.show', $grade) }}" class="grade-card">
        <div class="grade-header">
          <div class="grade-icon">{{ $icon }}</div>
          <div class="grade-num">{{ $idx + 1 }}</div>
        </div>
        <div>
          <div class="grade-title">{{ $grade->name }}</div>
          <div class="grade-sub">{{ $stage->name }}</div>
        </div>
        <div class="grade-footer">
          <div class="grade-count">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            {{ $subCount }} كورس
          </div>
          <span class="btn-details">عرض التفاصيل</span>
        </div>
      </a>
    @empty
      <p class="text-muted" style="grid-column:1/-1;text-align:center;padding:2rem;">لا توجد صفوف لهذه المرحلة حالياً.</p>
    @endforelse
  </div>
</section>

<section class="features-section">
  <div class="section-header">
    <h2>ماذا ستتعلم معنا؟</h2>
    <p>مش بس منهج... مهارات ومعرفة تفضل معاك دراسياً</p>
  </div>
  <div class="features-grid">
    <div class="feat-card">
      <div class="feat-icon">🧠</div>
      <div class="feat-title">فهم عميق للمناهج الدراسية</div>
    </div>
    <div class="feat-card">
      <div class="feat-icon">🎯</div>
      <div class="feat-title">الفهم والتطبيق لراحة النظام</div>
    </div>
    <div class="feat-card">
      <div class="feat-icon">📋</div>
      <div class="feat-title">حل الامتحانات بثقة</div>
    </div>
    <div class="feat-card">
      <div class="feat-icon">📊</div>
      <div class="feat-title">تطبيق وحب التحاليل بنجاح</div>
    </div>
    <div class="feat-card">
      <div class="feat-icon">📈</div>
      <div class="feat-title">متابعة مستواك ومعرفة نقاطك</div>
    </div>
  </div>
  <div class="feat-cta">
    <a href="{{ route('front.contact') }}" class="btn-contact">
      <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.16 6.16l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      تواصل معنا
    </a>
  </div>
</section>
@endsection
