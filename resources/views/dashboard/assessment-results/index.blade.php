@extends('dashboard.layouts.backend', ['title' => 'نتائج التقييمات'])

@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/assessment-results.css') }}">
@endsection

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">نتائج التقييمات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>نتائج التقييمات</h1>
    </div>
    <x-alert-component></x-alert-component>

    <div class="filters-bar-ds fade-up-ds delay-1-ds" style="margin-bottom:12px">
        <div class="filters-right-ds">
            @if(($students ?? collect())->count() > 0)
                <select id="filter_student_id" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:160px" onchange="filterAssessmentResults()">
                    <option value="">جميع الطلاب</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>
                            {{ $student->full_name ?? trim(($student->f_name ?? '') . ' ' . ($student->l_name ?? '')) ?: ($student->email ?? '—') }}
                        </option>
                    @endforeach
                </select>
            @endif
            @if(($subjects ?? collect())->count() > 0)
                <select id="filter_subject_id" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:160px" onchange="filterAssessmentResults()">
                    <option value="">جميع المواد</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected(request('subject_id') == $subject->id)>{{ $subject->name }}</option>
                    @endforeach
                </select>
            @endif
            @if(($types ?? collect())->count() > 0)
                <select id="filter_type" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:130px" onchange="filterAssessmentResults()">
                    <option value="">كل الأنواع</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected(request('type') == $type)>{{ $type }}</option>
                    @endforeach
                </select>
            @endif
            <input type="date" id="filter_from_date" class="form-control form-control-sm filter-select-ds"
                style="width:auto;min-width:140px" value="{{ request('from_date') }}" onchange="filterAssessmentResults()">
            <input type="date" id="filter_to_date" class="form-control form-control-sm filter-select-ds"
                style="width:auto;min-width:140px" value="{{ request('to_date') }}" onchange="filterAssessmentResults()">
            <a href="{{ route('dashboard.assessment-results.index') }}" class="filter-badge-ds"
                style="text-decoration:none">إعادة ضبط</a>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.assessment-results.index') }}" method="get" class="search-wrap-ds">
                @if(request('student_id'))<input type="hidden" name="student_id" value="{{ request('student_id') }}">@endif
                @if(request('subject_id'))<input type="hidden" name="subject_id" value="{{ request('subject_id') }}">@endif
                @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
                @if(request('from_date'))<input type="hidden" name="from_date" value="{{ request('from_date') }}">@endif
                @if(request('to_date'))<input type="hidden" name="to_date" value="{{ request('to_date') }}">@endif
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث بالطالب أو التقييم...">
            </form>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-1-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>التقييم</th>
                    <th>النوع</th>
                    <th>المادة</th>
                    <th>الدرجة</th>
                    <th>تاريخ الحل</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    @php
                        $assessment = $result->assessment;
                        $subject = $assessment?->subject;
                        $percentage = $result->max_score > 0 ? round(($result->score / $result->max_score) * 100) : 0;
                        $resultClass = $percentage >= 50 ? 'pass' : 'fail';
                    @endphp
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $result->user?->full_name ?? $result->user?->fullname ?? '—' }}</span></td>
                        <td style="font-size:.9rem">{{ $assessment?->title ?? '—' }}</td>
                        <td><span class="assessment-type-chip">{{ $assessment?->type ?? '—' }}</span></td>
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
                        <td>
                            <span class="assessment-score-badge {{ $resultClass }}">
                                {{ $result->score }} / {{ $result->max_score }}
                            </span>
                        </td>
                        <td style="font-size:.85rem;color:var(--muted)">{{ ($result->submitted_at ?? $result->created_at)?->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('dashboard.assessment-results.show', $result->id) }}" class="assessment-view-btn" title="عرض الإجابات">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                عرض
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد نتائج تقييمات</td>
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

@push('scripts')
    <script>
        function filterAssessmentResults() {
            var studentId = document.getElementById('filter_student_id') ? document.getElementById('filter_student_id').value : '';
            var subjectId = document.getElementById('filter_subject_id') ? document.getElementById('filter_subject_id').value : '';
            var type = document.getElementById('filter_type') ? document.getElementById('filter_type').value : '';
            var fromDate = document.getElementById('filter_from_date') ? document.getElementById('filter_from_date').value : '';
            var toDate = document.getElementById('filter_to_date') ? document.getElementById('filter_to_date').value : '';

            var url = new URL(window.location.href);
            if (studentId) url.searchParams.set('student_id', studentId); else url.searchParams.delete('student_id');
            if (subjectId) url.searchParams.set('subject_id', subjectId); else url.searchParams.delete('subject_id');
            if (type) url.searchParams.set('type', type); else url.searchParams.delete('type');
            if (fromDate) url.searchParams.set('from_date', fromDate); else url.searchParams.delete('from_date');
            if (toDate) url.searchParams.set('to_date', toDate); else url.searchParams.delete('to_date');
            window.location.href = url.toString();
        }
    </script>
@endpush
