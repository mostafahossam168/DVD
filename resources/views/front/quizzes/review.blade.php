@extends('front.layouts.front', ['title' => 'فاهم — مراجعة: ' . $quiz->title])

@section('content')
@php
    $subject = $quiz->lecture?->subject;
    $grade = $subject?->grade;
    $stage = $grade?->stage;
    $totalQ = $questions->count();
    $passed = $result->max_score > 0 && (round($result->score / $result->max_score * 100) >= 50);
@endphp

<div class="quiz-page-wrap">
    {{-- Score banner --}}
    <div class="score-banner {{ $passed ? 'pass' : 'fail' }}">
        <div class="score-icon">{{ $passed ? '🎉' : '📝' }}</div>
        <div class="score-info">
            <div class="score-title">{{ $passed ? 'أحسنت! لقد اجتزت الاختبار' : 'حاول مرة أخرى' }}</div>
            <div class="score-sub">درجتك: {{ $result->score }} من {{ $result->max_score }} ({{ $result->max_score > 0 ? round($result->score / $result->max_score * 100) : 0 }}٪)</div>
        </div>
        <div class="score-num">
            <div class="score-big">{{ $result->score }}</div>
            <div class="score-out">من {{ $result->max_score }}</div>
        </div>
    </div>

    {{-- Quiz header (compact) --}}
    <div class="quiz-header" style="margin-bottom:20px">
        <div class="quiz-eyebrow">📝 مراجعة الاختبار</div>
        <h1 class="quiz-title">{{ $quiz->title }}</h1>
        <div class="quiz-meta">{{ $subject?->name ?? '' }} — {{ $grade?->name ?? '' }} — {{ $stage?->name ?? '' }}</div>
    </div>

    @foreach($questions as $index => $question)
        @php
            $detail = $detailsByQuestion->get($question->id, []);
            $qNum = $index + 1;
            $isCorrect = (bool) ($detail['is_correct'] ?? false);
            $earned = $isCorrect ? $question->grade : 0;
            $answersArray = is_array($question->answers) ? $question->answers : (json_decode($question->answers ?? '[]', true) ?: []);
            $selectedIndex = $detail['selected_index'] ?? null;
        @endphp
        <div class="question-card">
            <div class="q-card-header">
                <div class="q-num-badge {{ $isCorrect ? 'badge-correct' : 'badge-wrong' }}">{{ $qNum }}</div>
                <div class="q-header-text">
                    <div class="q-title">سؤال {{ $qNum }}</div>
                    <div class="q-points-row">
                        <span class="q-points {{ $isCorrect ? 'points-correct' : 'points-wrong' }}">{{ $earned }} / {{ $question->grade }} درجة</span>
                        <span class="q-status-chip {{ $isCorrect ? 'chip-correct' : 'chip-wrong' }}">{{ $isCorrect ? '✓ إجابة صحيحة' : '✗ إجابة خاطئة' }}</span>
                    </div>
                </div>
            </div>
            <div class="q-card-body">
                <div class="q-text">{{ $question->question }}</div>

                @if($question->type === 'mcq')
                    <div class="q-options">
                        @foreach($answersArray as $aIndex => $answer)
                            @php
                                $isCorrectOpt = !empty($answer['is_correct']);
                                $isStudentChoice = $selectedIndex === $aIndex;
                                $optClass = 'q-option disabled';
                                if ($isCorrectOpt) $optClass .= ' correct';
                                elseif ($isStudentChoice) $optClass .= ' wrong';
                            @endphp
                            <div class="{{ $optClass }}">
                                <div class="q-opt-indicator">{{ $isCorrectOpt ? '✓' : ($isStudentChoice ? '✗' : '') }}</div>
                                <span class="q-opt-label">{{ $answer['answer'] ?? '' }}</span>
                                @if($isCorrectOpt)<span class="q-opt-tag tag-correct">الإجابة الصحيحة</span>@endif
                                @if($isStudentChoice && !$isCorrectOpt)<span class="q-opt-tag tag-wrong">إجابتك</span>@endif
                                @if($isStudentChoice && $isCorrectOpt)<span class="q-opt-tag tag-your">إجابتك</span>@endif
                            </div>
                        @endforeach
                    </div>
                @else
                    @php($studentAnswer = $detail['answer'] ?? '')
                    <div class="text-answer-wrap">
                        @if($studentAnswer)
                            <div class="text-answer-box submitted" style="margin-bottom:10px">{{ $studentAnswer }}</div>
                        @endif
                        @if($question->correct_answer)
                            <div class="model-answer">
                                <span class="model-answer-label">✅ الإجابة النموذجية:</span>
                                <span class="model-answer-text">{{ $question->correct_answer }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="submit-section">
        <div class="submit-title">تمت المراجعة</div>
        <div class="submit-sub">يمكنك العودة للدرس أو لاختباراتك.</div>
        <a href="{{ route('front.courses.lesson', [$subject, $quiz->lecture]) }}" class="btn-submit-quiz" style="text-decoration:none; margin-left:8px">العودة للدرس</a>
        <a href="{{ route('front.quizzes.history') }}" class="btn-submit-quiz btn-modal-cancel" style="text-decoration:none">اختباراتي</a>
    </div>
</div>
@endsection
