@extends('dashboard.layouts.backend', ['title' => 'عرض التقييم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.assessments.index') }}">التقييمات</a>
        <span class="sep">/</span>
        <span class="current">عرض التقييم</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>عرض التقييم</h1>
        <div class="page-header-actions">
            @can('update_assessments')
                <a href="{{ route('dashboard.assessments.edit', $assessment->id) }}" class="btn-add-ds">تعديل</a>
            @endcan
        </div>
    </div>

    <a href="{{ route('dashboard.assessments.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>

    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#e0e7ff">📝</div>
            <div>
                <h2>{{ $assessment->title }}</h2>
                <p>تفاصيل التقييم والأسئلة المرتبطة به</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-grid-ds">
                <div class="form-group-ds"><label class="form-label-ds">النوع</label><div class="form-control-ds">{{ $assessment->type }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">المعلم</label><div class="form-control-ds">{{ $assessment->teacher?->full_name ?? '—' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">المرحلة</label><div class="form-control-ds">{{ $assessment->stage?->name ?? '—' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">الصف</label><div class="form-control-ds">{{ $assessment->grade?->name ?? '—' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">المادة</label><div class="form-control-ds">{{ $assessment->subject?->name ?? '—' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">المدة</label><div class="form-control-ds">{{ $assessment->duration ?? '—' }} دقيقة</div></div>
                <div class="form-group-ds"><label class="form-label-ds">الحالة</label><div class="form-control-ds">{{ $assessment->status ? 'مفعل' : 'غير مفعل' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">البداية</label><div class="form-control-ds">{{ $assessment->start_time?->format('Y-m-d H:i') ?? '—' }}</div></div>
                <div class="form-group-ds"><label class="form-label-ds">النهاية</label><div class="form-control-ds">{{ $assessment->end_time?->format('Y-m-d H:i') ?? '—' }}</div></div>
            </div>

            <div class="form-divider-ds">الأسئلة المرتبطة</div>
            <div class="table-wrap-ds">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>السؤال</th>
                            <th>النوع</th>
                            <th>الدرجة</th>
                            <th>الترتيب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessment->questions as $q)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($q->question_text, 120) }}</td>
                                <td>{{ $q->type }}</td>
                                <td>{{ $q->pivot->mark ?? $q->default_mark ?? '—' }}</td>
                                <td>{{ $q->pivot->order ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;padding:1.5rem">لا توجد أسئلة مرتبطة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
