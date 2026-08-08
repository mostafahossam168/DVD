@extends('dashboard.layouts.backend', ['title' => 'الملف الشخصي — ' . ($student->full_name ?? '')])

@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/student-profile.css') }}">
@endsection

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.students.index') }}">الطلاب</a>
        <span class="sep">/</span>
        <span class="current">{{ $student->full_name }}</span>
    </div>

    <x-alert-component></x-alert-component>

    {{-- Hero --}}
    <div class="sp-hero fade-up-ds">
        <div class="sp-hero-main">
            <div class="sp-avatar-wrap">
                @if($student->image && file_exists(public_path('uploads/' . $student->image)))
                    <img src="{{ display_file($student->image) }}" alt="" class="sp-avatar">
                @else
                    <div class="sp-avatar sp-avatar-ph">{{ mb_substr($student->full_name ?? $student->email, 0, 1) }}</div>
                @endif
                <span class="sp-presence-dot {{ $student->isOnline() ? 'online' : 'offline' }}" title="{{ $student->last_seen_label }}"></span>
            </div>
            <div class="sp-info">
                <div class="sp-name-row">
                    <h1>{{ $student->full_name }}</h1>
                    @if($student->status)
                        <span class="status-badge-ds enabled-ds">مفعل</span>
                    @else
                        <span class="status-badge-ds disabled-ds">غير مفعل</span>
                    @endif
                </div>
                <div class="sp-presence-label {{ $student->isOnline() ? 'online' : 'offline' }}">
                    <span class="sp-presence-dot-sm {{ $student->isOnline() ? 'online' : 'offline' }}"></span>
                    {{ $student->last_seen_label }}
                </div>
                <div class="sp-contact-row">
                    <span>📧 {{ $student->email }}</span>
                    <span style="direction:ltr">📱 {{ $student->phone ?? '—' }}</span>
                    <span>🗓️ عضو منذ {{ $student->created_at->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>
        <div class="sp-hero-actions">
            @can('update_students')
                <a href="{{ route('dashboard.students.edit', $student->id) }}" class="btn-ds btn-secondary-ds">تعديل البيانات</a>
            @endcan
        </div>
    </div>

    {{-- Quick stats --}}
    <div class="sp-stats fade-up-ds delay-1-ds">
        <div class="sp-stat-card">
            <div class="sp-stat-value">{{ $student->courseSubscriptions->where('status', true)->count() }}</div>
            <div class="sp-stat-label">اشتراكات نشطة</div>
        </div>
        <div class="sp-stat-card">
            <div class="sp-stat-value">{{ $assessmentResults->count() }}</div>
            <div class="sp-stat-label">امتحانات/تقييمات مؤداة</div>
        </div>
        <div class="sp-stat-card">
            <div class="sp-stat-value">
                {{ $assessmentResults->count() ? round($assessmentResults->avg(fn($r) => $r->max_score > 0 ? ($r->score / $r->max_score) * 100 : 0)) . '%' : '—' }}
            </div>
            <div class="sp-stat-label">متوسط الدرجات</div>
        </div>
        <div class="sp-stat-card">
            <div class="sp-stat-value">{{ $student->guardians->count() }}</div>
            <div class="sp-stat-label">أولياء أمور مرتبطين</div>
        </div>
    </div>

    {{-- المواد والاشتراكات --}}
    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#eff6ff">📚</div>
            <div>
                <h2>المواد والاشتراكات</h2>
                <p>المواد المسجلة وحالة الاشتراك الحالية.</p>
            </div>
        </div>
        <div class="form-card-body-ds" style="padding:0">
            @if($student->courseSubscriptions->count())
                <div style="overflow-x:auto">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th>المادة</th>
                                <th>الصف / المرحلة</th>
                                <th>نوع الاشتراك</th>
                                <th>الفترة</th>
                                <th>حالة الدفع</th>
                                <th>الحالة الآن</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->courseSubscriptions as $sub)
                                @php
                                    $today = now()->startOfDay();
                                    $isCurrentPeriod = $sub->period_type === 'month'
                                        ? ($sub->start_date && $sub->end_date && $today->between(\Carbon\Carbon::parse($sub->start_date), \Carbon\Carbon::parse($sub->end_date)))
                                        : true;
                                    $isPaidNow = $isCurrentPeriod && $sub->status && $sub->payment_status === 'paid';
                                @endphp
                                <tr>
                                    <td style="font-weight:800">{{ $sub->subject->name ?? '—' }}</td>
                                    <td style="font-size:.85rem;color:var(--muted)">
                                        {{ $sub->subject->grade->name ?? '—' }} — {{ $sub->subject->grade->stage->name ?? '—' }}
                                    </td>
                                    <td style="font-size:.85rem">{{ $sub->period_type === 'month' ? 'شهري' : 'ترم' }}</td>
                                    <td style="font-size:.85rem;color:var(--muted)">
                                        @if($sub->period_type === 'term')
                                            {{ $sub->term_number ? 'ترم ' . $sub->term_number : '—' }}
                                        @else
                                            @if($sub->start_date && $sub->end_date)
                                                {{ \Carbon\Carbon::parse($sub->start_date)->format('Y-m-d') }} → {{ \Carbon\Carbon::parse($sub->end_date)->format('Y-m-d') }}
                                            @else
                                                —
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub->payment_status === 'paid')
                                            <span class="status-badge-ds enabled-ds">مدفوع</span>
                                        @elseif($sub->payment_status === 'rejected')
                                            <span class="status-badge-ds disabled-ds">مرفوض</span>
                                        @else
                                            <span class="status-badge-ds" style="background:#fff7ed;color:#c2410c">معلق</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub->period_type === 'month')
                                            @if($isPaidNow)
                                                <span class="status-badge-ds enabled-ds">✅ دافع الشهر ده</span>
                                            @elseif($isCurrentPeriod)
                                                <span class="status-badge-ds" style="background:#fef2f2;color:#dc2626">❌ لسه مادفعش الشهر ده</span>
                                            @else
                                                <span class="status-badge-ds disabled-ds">منتهي</span>
                                            @endif
                                        @else
                                            @if($sub->status)
                                                <span class="status-badge-ds enabled-ds">نشط</span>
                                            @else
                                                <span class="status-badge-ds disabled-ds">غير نشط</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="empty-state-ds">لا توجد اشتراكات مسجلة.</p>
            @endif
        </div>
    </div>

    {{-- نتائج الامتحانات --}}
    <div class="form-card-ds fade-up-ds delay-2-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#dcfce7">📝</div>
            <div>
                <h2>الامتحانات والتقييمات</h2>
                <p>النتائج المسجلة للاختبارات والواجبات.</p>
            </div>
        </div>
        <div class="form-card-body-ds" style="padding:0">
            @if($assessmentResults->count())
                <div style="overflow-x:auto">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>المادة</th>
                                <th>الدرجة</th>
                                <th>تاريخ التسليم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $typeLabels = ['exam' => 'امتحان', 'quiz' => 'كويز', 'assignment' => 'واجب']; @endphp
                            @foreach($assessmentResults as $result)
                                @php
                                    $percentage = $result->max_score > 0 ? round(($result->score / $result->max_score) * 100) : 0;
                                @endphp
                                <tr>
                                    <td style="font-weight:800">{{ $result->assessment?->title ?? '—' }}</td>
                                    <td><span class="assessment-type-chip">{{ $typeLabels[$result->assessment?->type] ?? '—' }}</span></td>
                                    <td style="font-size:.85rem">{{ $result->assessment?->subject?->name ?? '—' }}</td>
                                    <td>
                                        <span class="assessment-score-badge {{ $percentage >= 50 ? 'pass' : 'fail' }}">
                                            {{ $result->score }} / {{ $result->max_score }} ({{ $percentage }}%)
                                        </span>
                                    </td>
                                    <td style="font-size:.85rem;color:var(--muted)">{{ ($result->submitted_at ?? $result->created_at)?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="empty-state-ds">لا توجد نتائج مسجلة.</p>
            @endif
        </div>
    </div>

    {{-- أولياء الأمور --}}
    <div class="form-card-ds fade-up-ds delay-2-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#fdf4ff">👨‍👩‍👧</div>
            <div>
                <h2>أولياء الأمور</h2>
                <p>الحسابات المرتبطة بهذا الطالب.</p>
            </div>
            @can('read_parents')
                <a href="{{ route('dashboard.parents.index') }}" class="btn-ds btn-secondary-ds" style="margin-inline-start:auto">إدارة أولياء الأمور</a>
            @endcan
        </div>
        <div class="form-card-body-ds">
            @if($student->guardians->count())
                <div class="sp-guardians-grid">
                    @foreach($student->guardians as $guardian)
                        <div class="sp-guardian-card">
                            <div class="sp-guardian-avatar">{{ mb_substr($guardian->full_name ?? $guardian->email, 0, 1) }}</div>
                            <div>
                                <div style="font-weight:800">{{ $guardian->full_name }}</div>
                                <div style="font-size:.8rem;color:var(--muted)">{{ $guardian->email }}</div>
                                <div style="font-size:.8rem;color:var(--muted);direction:ltr;text-align:right">{{ $guardian->phone ?? '—' }}</div>
                            </div>
                            @can('update_parents')
                                <a href="{{ route('dashboard.parents.edit', $guardian->id) }}" class="action-btn-ds edit-ds" title="تعديل" style="margin-inline-start:auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty-state-ds">لا يوجد ولي أمر مرتبط بهذا الطالب.</p>
            @endif
        </div>
    </div>
</div>
@endsection
