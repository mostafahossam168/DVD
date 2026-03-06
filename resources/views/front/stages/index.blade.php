@extends('front.layouts.front', ['title' => 'المراحل الدراسية'])

@section('content')
@php
  $colors = ['blue', 'purple', 'green', 'orange', 'rose', 'teal'];
  $icons = ['🎓', '📚', '🏆', '🌟', '✏️', '🌍'];
@endphp

<div class="stages-hero">
  <h1>المراحل الدراسية</h1>
  <p>اختر مرحلتك الدراسية لعرض الصفوف والمواد المتاحة</p>
</div>

<div class="stages-grid-wrap">
  <div class="stages-grid">
    @forelse ($stages ?? [] as $index => $stage)
      @php
        $color = $colors[$index % count($colors)];
        $icon = $icons[$index % count($icons)];
        $gradesCount = $stage->grades->count();
      @endphp
      <a href="{{ route('front.stages.show', $stage) }}" class="stage-card" data-color="{{ $color }}">
        <div class="sc-icon">{{ $icon }}</div>
        <div class="sc-title">{{ $stage->name }}</div>
        <div class="sc-sub">اختر صفك لعرض المواد والكورسات</div>
        <div class="sc-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          {{ $gradesCount }} صفوف دراسية
        </div>
      </a>
    @empty
      <p class="text-muted" style="grid-column:1/-1;text-align:center;padding:2rem;">لا توجد مراحل دراسية حالياً.</p>
    @endforelse
  </div>
</div>
@endsection
