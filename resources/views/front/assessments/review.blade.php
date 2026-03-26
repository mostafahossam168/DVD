@extends('front.layouts.front', ['title' => 'فاهم — مراجعة: ' . $assessment->title])

@section('content')
@php
    $subject = $assessment->subject;
    $grade = $subject?->grade;
    $stage = $grade?->stage;
    $passed = $result->max_score > 0 && (round($result->score / $result->max_score * 100) >= 50);
@endphp

<div class="quiz-page-wrap">
    <div class="score-banner {{ $passed ? 'pass' : 'fail' }}">
        <div class="score-icon">{{ $passed ? '🎉' : '📝' }}</div>
        <div class="score-info">
            <div class="score-title">{{ $passed ? 'أحسنت! تم اجتياز التقييم' : 'حاول مرة أخرى' }}</div>
            <div class="score-sub">درجتك: {{ $result->score }} من {{ $result->max_score }} ({{ $result->max_score > 0 ? round($result->score / $result->max_score * 100) : 0 }}٪)</div>
        </div>
    </div>

    <div class="quiz-header" style="margin-bottom:20px">
        <div class="quiz-eyebrow">🧪 مراجعة التقييم</div>
        <h1 class="quiz-title">{{ $assessment->title }}</h1>
        <div class="quiz-meta">{{ $subject?->name ?? '' }} — {{ $grade?->name ?? '' }} — {{ $stage?->name ?? '' }}</div>
    </div>

    @foreach($questions as $index => $question)
        @php
            $detail = $detailsByQuestion->get($question->id, []);
            $isCorrect = (bool) ($detail['is_correct'] ?? false);
            $mark = (int) ($detail['mark'] ?? $question->pivot->mark ?? $question->default_mark ?? 1);
            $answersArray = is_array($question->answers) ? $question->answers : (json_decode($question->answers ?? '[]', true) ?: []);
            $selectedIndex = $detail['selected_index'] ?? null;
        @endphp
        <div class="question-card">
            <div class="q-card-header">
                <div class="q-num-badge {{ $isCorrect ? 'badge-correct' : 'badge-wrong' }}">{{ $index + 1 }}</div>
                <div class="q-header-text">
                    <div class="q-title">سؤال {{ $index + 1 }}</div>
                    <div class="q-points-row">
                        <span class="q-points {{ $isCorrect ? 'points-correct' : 'points-wrong' }}">{{ $isCorrect ? $mark : 0 }} / {{ $mark }} درجة</span>
                        <span class="q-status-chip {{ $isCorrect ? 'chip-correct' : 'chip-wrong' }}">{{ $isCorrect ? '✓ صحيحة' : '✗ خاطئة' }}</span>
                    </div>
                </div>
            </div>
            <div class="q-card-body">
                <div class="q-text">{{ $question->question_text }}</div>

                @if($question->type === 'mcq')
                    <div class="q-options">
                        @foreach($answersArray as $aIndex => $answer)
                            @php
                                $isCorrectOpt = !empty($answer['is_correct']);
                                $isStudentChoice = $selectedIndex === $aIndex;
                            @endphp
                            <div class="q-option disabled {{ $isCorrectOpt ? 'correct' : ($isStudentChoice ? 'wrong' : '') }}">
                                <div class="q-opt-indicator">{{ $isCorrectOpt ? '✓' : ($isStudentChoice ? '✗' : '') }}</div>
                                <span class="q-opt-label">{{ $answer['answer'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-answer-wrap">
                        <div class="text-answer-box submitted">{{ $detail['answer'] ?? '—' }}</div>
                        <div class="model-answer">
                            <span class="model-answer-label">✅ الإجابة النموذجية:</span>
                            <span class="model-answer-text">{{ $question->correct_answer ?? '—' }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="submit-section">
        <a href="{{ route('front.courses.subject', $subject) }}" class="btn-submit-quiz" style="text-decoration:none">العودة للكورس</a>
    </div>
</div>
@endsection
