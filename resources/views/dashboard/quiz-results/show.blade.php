@extends('dashboard.layouts.backend', ['title' => 'تفاصيل نتيجة اختبار'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.quiz-results.index') }}">نتائج الاختبارات</a>
        <span class="sep">/</span>
        <span class="current">تفاصيل نتيجة</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>{{ $quiz->title }}</h1>
    </div>
    <a href="{{ route('dashboard.quiz-results.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>

    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#dcfce7">📋</div>
            <div>
                <h2>ملخص النتيجة</h2>
                <p>الطالب، الدرجة والمادة.</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-grid-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds">الطالب</label>
                    <p class="mb-0">{{ $result->user?->full_name ?? '-' }}</p>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الدرجة</label>
                    <p class="mb-0">{{ $result->score }} / {{ $result->max_score }}</p>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">المادة</label>
                    <p class="mb-0">
                        @if ($subject)
                            {{ $subject->name }}
                            @if ($subject->grade)
                                - {{ $subject->grade->name }}
                                @if ($subject->grade->stage)
                                    - {{ $subject->grade->stage->name }}
                                @endif
                            @endif
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @foreach ($questions as $index => $question)
        @php
            $detail = $detailsByQuestion->get($question->id, []);
        @endphp
        <div class="form-card-ds fade-up-ds mt-4">
            <div class="form-card-body-ds">
                <h5 class="mb-2" style="font-weight:600">سؤال {{ $index + 1 }} (الدرجة: {{ $question->grade }})</h5>
                <p class="mb-3">{{ $question->question }}</p>

                @if ($question->type === 'mcq')
                    @php
                        $answersArray = is_array($question->answers)
                            ? $question->answers
                            : (json_decode($question->answers ?? '[]', true) ?: []);
                        $selectedIndex = $detail['selected_index'] ?? null;
                    @endphp
                    @foreach ($answersArray as $aIndex => $answer)
                        @php $isStudentChoice = $selectedIndex === $aIndex; @endphp
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <input class="form-check-input" type="radio" disabled {{ $isStudentChoice ? 'checked' : '' }}>
                            <span>
                                {{ $answer['answer'] ?? '' }}
                                @if (!empty($answer['is_correct']))
                                    <span class="status-badge-ds success-ds ms-1">إجابة صحيحة</span>
                                @endif
                                @if ($isStudentChoice && empty($answer['is_correct']))
                                    <span class="status-badge-ds danger-ds ms-1">إجابة الطالب</span>
                                @elseif($isStudentChoice)
                                    <span class="status-badge-ds primary-ds ms-1">إجابة الطالب</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                @else
                    @php($studentAnswer = $detail['answer'] ?? '')
                    <p class="mb-1"><strong>إجابة الطالب:</strong></p>
                    <p class="border rounded p-2 bg-light mb-2">{{ $studentAnswer ?: 'لم يكتب إجابة' }}</p>
                    @if ($question->correct_answer)
                        <p class="mb-0 form-hint-ds"><strong>الإجابة النموذجية:</strong> {{ $question->correct_answer }}</p>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
