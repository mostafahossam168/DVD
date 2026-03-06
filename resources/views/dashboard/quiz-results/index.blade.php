@extends('dashboard.layouts.backend', ['title' => 'نتائج الاختبارات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">نتائج الاختبارات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>نتائج الاختبارات</h1>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-1-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>الاختبار</th>
                    <th>المادة</th>
                    <th>الدرجة</th>
                    <th>تاريخ الحل</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    @php
                        $quiz = $result->quiz;
                        $subject = $quiz?->lecture?->subject;
                    @endphp
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $result->user?->full_name ?? $result->user?->fullname ?? '—' }}</span></td>
                        <td style="font-size:.9rem">{{ $quiz?->title ?? '—' }}</td>
                        <td style="font-size:.85rem">
                            @if($subject)
                                {{ $subject->name }}
                                @if($subject->grade)
                                    - {{ $subject->grade->name }}
                                    @if($subject->grade->stage)
                                        - {{ $subject->grade->stage->name }}
                                    @endif
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td><strong>{{ $result->score }}</strong> / {{ $result->max_score }}</td>
                        <td style="font-size:.85rem;color:var(--muted)">{{ $result->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('dashboard.quiz-results.show', $result->id) }}" class="action-btn-ds edit-ds" title="عرض الإجابات">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                عرض
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد نتائج</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($results->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">{{ $results->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
