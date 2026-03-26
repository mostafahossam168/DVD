@extends('dashboard.layouts.backend', ['title' => 'عرض السؤال'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.question-bank.index') }}">أسئلة التقييمات</a>
        <span class="sep">/</span>
        <span class="current">عرض السؤال</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>عرض السؤال</h1>
        <div class="page-header-actions">
            @can('update_question_bank')
                <a href="{{ route('dashboard.question-bank.edit', $question->id) }}" class="btn-add-ds">تعديل</a>
            @endcan
        </div>
    </div>

    <a href="{{ route('dashboard.question-bank.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>

    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#e0e7ff">👁️</div>
            <div>
                <h2>{{ \Illuminate\Support\Str::limit($question->question_text, 120) }}</h2>
                <p>تفاصيل السؤال داخل أسئلة التقييمات</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-grid-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds">النوع</label>
                    <div class="form-control-ds">{{ $question->type }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الصعوبة</label>
                    <div class="form-control-ds">{{ $question->difficulty }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الدرجة الافتراضية</label>
                    <div class="form-control-ds">{{ $question->default_mark ?? '—' }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">المرحلة</label>
                    <div class="form-control-ds">{{ $question->stage?->name ?? '—' }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الصف</label>
                    <div class="form-control-ds">{{ $question->grade?->name ?? '—' }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">المادة</label>
                    <div class="form-control-ds">{{ $question->subject?->name ?? '—' }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الحالة</label>
                    <div class="form-control-ds">{{ $question->status ? 'مفعل' : 'غير مفعل' }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">التصنيفات</label>
                    <div class="form-control-ds">
                        @forelse($question->categories as $cat)
                            <span class="status-badge-ds" style="margin:2px">{{ $cat->name }}</span>
                        @empty
                            —
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="form-divider-ds">نص السؤال</div>
            <div class="form-control-ds" style="min-height:72px">{{ $question->question_text }}</div>

            @if($question->type === 'mcq')
                <div class="form-divider-ds">الاختيارات</div>
                @forelse(($question->answers ?? []) as $idx => $ans)
                    <div class="d-flex align-items-center justify-content-between form-control-ds mb-2">
                        <span>{{ $idx + 1 }} - {{ $ans['answer'] ?? '' }}</span>
                        @if(!empty($ans['is_correct']))
                            <span class="status-badge-ds enabled-ds">الإجابة الصحيحة</span>
                        @endif
                    </div>
                @empty
                    <div class="form-control-ds">لا توجد اختيارات</div>
                @endforelse
            @else
                <div class="form-divider-ds">الإجابة الصحيحة</div>
                <div class="form-control-ds">{{ $question->correct_answer ?: '—' }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
