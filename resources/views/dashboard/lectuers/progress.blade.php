@extends('dashboard.layouts.backend', ['title' => 'مشاهدات المحاضرة'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.lectuers.index') }}">الدروس</a>
        <span class="sep">/</span>
        <span class="current">مشاهدات المحاضرة</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>مشاهدات: {{ $lecture->title }}</h1>
    </div>

    <a href="{{ route('dashboard.lectuers.index') }}" class="btn-back-ds fade-up-ds">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        رجوع
    </a>

    <div class="table-wrap-ds fade-up-ds delay-1-ds" style="margin-top:16px">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>نسبة المشاهدة</th>
                    <th>الحالة</th>
                    <th>آخر مشاهدة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php($progress = $student->lectureProgress->first())
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $student->full_name }}</span></td>
                        <td>{{ $progress->percent_watched ?? 0 }}%</td>
                        <td>
                            @if($progress && $progress->completed)
                                <span class="status-badge-ds enabled-ds">✅ شاهدها بالكامل</span>
                            @elseif($progress)
                                <span class="status-badge-ds" style="background:#fff7ed;color:#c2410c">⏳ لم يكملها</span>
                            @else
                                <span class="status-badge-ds disabled-ds">لم يشاهدها</span>
                            @endif
                        </td>
                        <td style="font-size:.85rem;color:var(--muted)">{{ $progress?->last_watched_at?->diffForHumans() ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا يوجد طلاب مشتركين في مادة هذه المحاضرة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
