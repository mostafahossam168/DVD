@extends('front.layouts.front', ['title' => 'فاهم — تقييماتي'])

@section('content')
<div class="quizzes-page-wrap" style="padding-top:24px">
    <div class="quizzes-hero">
        <div class="hero-left">
            <div class="hero-eyebrow">🧪 تقييماتي</div>
            <h1 class="hero-title">التقييمات التي <em>قمت بحلّها</em></h1>
            <p class="hero-sub">سجل كامل بالتقييمات ودرجاتك ونتائجك.</p>
        </div>
        <div class="hero-stats-cards">
            <div class="hsc"><div class="hsc-val">{{ $stats['all'] ?? 0 }}</div><div class="hsc-label">إجمالي التقييمات</div></div>
            <div class="hsc"><div class="hsc-val">{{ $stats['passed'] ?? 0 }}</div><div class="hsc-label">ناجح</div></div>
            <div class="hsc"><div class="hsc-val">{{ $stats['failed'] ?? 0 }}</div><div class="hsc-label">يحتاج مراجعة</div></div>
        </div>
    </div>

    <div class="quizzes-table-card">
        <div class="quizzes-table-header">
            <div class="quizzes-table-title">📋 سجل التقييمات</div>
        </div>
        <table class="quizzes-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التقييم</th>
                    <th>المادة</th>
                    <th>الدرجة</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    @php
                        $assessment = $result->assessment;
                        $subject = $assessment?->subject;
                        $pct = $result->max_score > 0 ? round(($result->score / $result->max_score) * 100) : 0;
                        $passed = $pct >= 50;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $assessment?->title ?? '—' }}</td>
                        <td>{{ $subject?->name ?? '—' }}</td>
                        <td>{{ $result->score }} / {{ $result->max_score }}</td>
                        <td>
                            <span class="status-chip {{ $passed ? 'passed' : 'failed' }}">
                                {{ $passed ? 'ناجح' : 'يحتاج مراجعة' }}
                            </span>
                        </td>
                        <td>{{ ($result->submitted_at ?? $result->created_at)?->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($assessment)
                                <a href="{{ route('front.assessments.review', $assessment) }}" class="action-btn review">👁 مراجعة</a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem">لا توجد تقييمات بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($results->hasPages())
            <div style="margin-top:12px">{{ $results->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
