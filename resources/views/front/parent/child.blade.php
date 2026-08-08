@extends('front.layouts.front', ['title' => 'فاهم — متابعة ' . ($student->full_name ?? '')])

@section('content')
<div class="hero-band hero-courses">
    <div class="hero-inner">
        <div class="hero-eyebrow">👨‍👩‍👧 بوابة ولي الأمر</div>
        <h1>متابعة <em>{{ $student->full_name }}</em></h1>
        <p>{{ $student->email }}</p>
    </div>
</div>

<div class="page-content courses-page-content" style="padding:32px 5% 80px">
    <a href="{{ route('front.parent.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;color:var(--muted);text-decoration:none;font-weight:700;font-size:.9rem">← الرجوع لكل الأبناء</a>

    {{-- المواد المشترك فيها --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <div class="profile-card-title">📚 المواد المشترك فيها</div>
        </div>
        <div class="profile-card-body">
            @if($subjects->count())
                <div class="profile-info-list">
                    @foreach($subjects as $subject)
                        <div class="profile-info-item">
                            <span class="profile-info-label">{{ $subject->name }}</span>
                            <span class="profile-info-value">{{ $subject->grade?->name ?? '—' }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color:var(--muted);font-size:.88rem;margin:0">لا يوجد اشتراكات فعّالة حالياً.</p>
            @endif
        </div>
    </div>

    {{-- نتائج التقييمات --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <div class="profile-card-title">📝 نتائج الامتحانات والواجبات</div>
        </div>
        <div class="profile-card-body" style="padding:0">
            @if($assessmentResults->count())
                <div style="overflow-x:auto">
                    <table style="width:100%;border-collapse:collapse;font-size:.86rem">
                        <thead>
                            <tr style="text-align:right;border-bottom:1px solid var(--border)">
                                <th style="padding:12px 16px">العنوان</th>
                                <th style="padding:12px 16px">النوع</th>
                                <th style="padding:12px 16px">المادة</th>
                                <th style="padding:12px 16px">الدرجة</th>
                                <th style="padding:12px 16px">تاريخ التسليم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assessmentResults as $result)
                                <tr style="border-bottom:1px solid var(--border)">
                                    <td style="padding:12px 16px;font-weight:700">{{ $result->assessment?->title ?? '—' }}</td>
                                    <td style="padding:12px 16px">
                                        @php
                                            $typeLabels = ['exam' => 'امتحان', 'quiz' => 'كويز', 'assignment' => 'واجب'];
                                        @endphp
                                        {{ $typeLabels[$result->assessment?->type] ?? '—' }}
                                    </td>
                                    <td style="padding:12px 16px">{{ $result->assessment?->subject?->name ?? '—' }}</td>
                                    <td style="padding:12px 16px;font-weight:800;color:var(--blue)">{{ $result->score }} / {{ $result->max_score }}</td>
                                    <td style="padding:12px 16px;color:var(--muted)">{{ $result->submitted_at?->format('Y-m-d H:i') ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color:var(--muted);font-size:.88rem;padding:16px">لا توجد نتائج بعد.</p>
            @endif
        </div>
    </div>

    {{-- حالة مشاهدة المحاضرات --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <div class="profile-card-title">🎬 حالة مشاهدة المحاضرات</div>
        </div>
        <div class="profile-card-body" style="padding:0">
            @if($lectureProgress->count())
                <div style="overflow-x:auto">
                    <table style="width:100%;border-collapse:collapse;font-size:.86rem">
                        <thead>
                            <tr style="text-align:right;border-bottom:1px solid var(--border)">
                                <th style="padding:12px 16px">المحاضرة</th>
                                <th style="padding:12px 16px">المادة</th>
                                <th style="padding:12px 16px">نسبة المشاهدة</th>
                                <th style="padding:12px 16px">الحالة</th>
                                <th style="padding:12px 16px">آخر مشاهدة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lectureProgress as $progress)
                                <tr style="border-bottom:1px solid var(--border)">
                                    <td style="padding:12px 16px;font-weight:700">{{ $progress->lecture?->title ?? '—' }}</td>
                                    <td style="padding:12px 16px">{{ $progress->lecture?->subject?->name ?? '—' }}</td>
                                    <td style="padding:12px 16px">{{ $progress->percent_watched }}%</td>
                                    <td style="padding:12px 16px">
                                        @if($progress->completed)
                                            <span class="tag" style="background:#DCFCE7;color:#166534">✅ شاهدها بالكامل</span>
                                        @else
                                            <span class="tag">⏳ لم يكملها</span>
                                        @endif
                                    </td>
                                    <td style="padding:12px 16px;color:var(--muted)">{{ $progress->last_watched_at?->diffForHumans() ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color:var(--muted);font-size:.88rem;padding:16px">لسه معملش أي مشاهدة لأي محاضرة.</p>
            @endif
        </div>
    </div>
</div>
@endsection
