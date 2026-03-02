@extends('front.layouts.front', ['title' => $quiz->title])

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-2">{{ $quiz->title }}</h1>
            <p class="text-muted mb-1">
                {{ $subject->name }} - {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
            </p>
            <p class="text-muted small mb-3">
                درجتك: {{ $result->score }} من {{ $result->max_score }}
            </p>

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
                                            <span class="badge bg-danger ms-1">إجابتك</span>
                                        @elseif($isStudentChoice)
                                            <span class="badge bg-primary ms-1">إجابتك</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        @else
                            @php($studentAnswer = $detail['answer'] ?? '')
                            <p class="mb-1"><strong>إجابتك:</strong></p>
                            <p class="border rounded p-2 bg-light">{{ $studentAnswer ?: 'لم تقم بالإجابة' }}</p>
                            @if ($question->correct_answer)
                                <p class="mb-0 small text-muted"><strong>الإجابة النموذجية:</strong>
                                    {{ $question->correct_answer }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

