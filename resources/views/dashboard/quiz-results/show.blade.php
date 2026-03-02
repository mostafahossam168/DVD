@extends('dashboard.layouts.backend', ['title' => 'تفاصيل نتيجة اختبار'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية / نتائج الاختبارات</div>
                <div class="large">{{ $quiz->title }}</div>
            </div>
            <a href="{{ route('dashboard.quiz-results.index') }}" class="main-btn btn-main-color">رجوع</a>
        </div>

        <x-alert-component></x-alert-component>

        <div class="mb-3">
            <p><strong>الطالب:</strong> {{ $result->user?->full_name ?? '-' }}</p>
            <p><strong>الدرجة:</strong> {{ $result->score }} / {{ $result->max_score }}</p>
            <p>
                <strong>المادة:</strong>
                @if ($subject)
                    {{ $subject->name }}
                    @if ($subject->grade)
                        - {{ $subject->grade->name }}
                        - {{ $subject->grade->stage?->name }}
                    @endif
                @else
                    -
                @endif
            </p>
        </div>

        @foreach ($questions as $index => $question)
            @php
                $detail = $detailsByQuestion->get($question->id, []);
            @endphp
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-2">
                        سؤال {{ $index + 1 }} (الدرجة: {{ $question->grade }})
                    </h5>
                    <p class="mb-3">{{ $question->question }}</p>

                    @if ($question->type === 'mcq')
                        @php
                            $answersArray = is_array($question->answers)
                                ? $question->answers
                                : (json_decode($question->answers ?? '[]', true) ?: []);
                            $selectedIndex = $detail['selected_index'] ?? null;
                        @endphp
                        @foreach ($answersArray as $aIndex => $answer)
                            @php
                                $isStudentChoice = $selectedIndex === $aIndex;
                            @endphp
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" disabled
                                    {{ $isStudentChoice ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $answer['answer'] ?? '' }}
                                    @if (!empty($answer['is_correct']))
                                        <span class="badge bg-success ms-1">إجابة صحيحة</span>
                                    @endif
                                    @if ($isStudentChoice && empty($answer['is_correct']))
                                        <span class="badge bg-danger ms-1">إجابة الطالب</span>
                                    @elseif($isStudentChoice)
                                        <span class="badge bg-primary ms-1">إجابة الطالب</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    @else
                        @php($studentAnswer = $detail['answer'] ?? '')
                        <p class="mb-1"><strong>إجابة الطالب:</strong></p>
                        <p class="border rounded p-2 bg-light">{{ $studentAnswer ?: 'لم يكتب إجابة' }}</p>
                        @if ($question->correct_answer)
                            <p class="mb-0 small text-muted"><strong>الإجابة النموذجية:</strong>
                                {{ $question->correct_answer }}</p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection

