@extends('front.layouts.front', ['title' => 'فاهم — ' . $assessment->title])

@section('content')
@php
    $subject = $assessment->subject;
    $grade = $subject?->grade;
    $stage = $grade?->stage;
    $totalQ = $questions->count();
    $totalScore = $questions->sum(function ($q) { return (int) ($q->pivot->mark ?? $q->default_mark ?? 1); });
@endphp

<div class="quiz-page-wrap">
    <div class="quiz-header">
        <div class="quiz-eyebrow">🧪 تقييم</div>
        <h1 class="quiz-title">{{ $assessment->title }}</h1>
        <div class="quiz-meta">{{ $subject?->name ?? '' }} — {{ $grade?->name ?? '' }} — {{ $stage?->name ?? '' }}</div>
        <div class="quiz-stats">
            <div class="quiz-stat"><span class="quiz-stat-val">{{ $totalQ }}</span><span class="quiz-stat-label">سؤال</span></div>
            <div class="quiz-stat"><span class="quiz-stat-val">{{ $totalScore }}</span><span class="quiz-stat-label">الدرجة الكلية</span></div>
            <div class="quiz-stat"><span class="quiz-stat-val">{{ $assessment->type }}</span><span class="quiz-stat-label">النوع</span></div>
            <div class="quiz-stat"><span class="quiz-stat-val">{{ $assessment->duration ?? '—' }} دقيقة</span><span class="quiz-stat-label">المدة</span></div>
        </div>
    </div>

    <form method="POST" action="{{ route('front.assessments.submit', $assessment) }}" id="assessmentForm">
        @csrf
        @foreach($questions as $index => $question)
            @php
                $mark = (int) ($question->pivot->mark ?? $question->default_mark ?? 1);
                $answersArray = is_array($question->answers) ? $question->answers : (json_decode($question->answers ?? '[]', true) ?: []);
            @endphp
            <div class="question-card">
                <div class="q-card-header">
                    <div class="q-num-badge badge-neutral">{{ $index + 1 }}</div>
                    <div class="q-header-text">
                        <div class="q-title">سؤال {{ $index + 1 }}</div>
                        <div class="q-points-row"><span class="q-points points-neutral">{{ $mark }} درجات</span></div>
                    </div>
                </div>
                <div class="q-card-body">
                    <div class="q-text">{{ $question->question_text }}</div>

                    @if($question->type === 'mcq')
                        <div class="q-options" id="qOptions{{ $question->id }}">
                            @foreach($answersArray as $aIndex => $answer)
                                <div class="q-option" data-question-id="{{ $question->id }}" role="button" tabindex="0">
                                    <div class="q-opt-indicator"></div>
                                    <span class="q-opt-label">{{ $answer['answer'] ?? '' }}</span>
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $aIndex }}" class="d-none">
                                </div>
                            @endforeach
                        </div>
                    @elseif($question->type === 'true_false')
                        <select class="enroll-select" name="answers_text[{{ $question->id }}]" required>
                            <option value="">اختر</option>
                            <option value="true">true</option>
                            <option value="false">false</option>
                        </select>
                    @else
                        <textarea class="text-answer-box" name="answers_text[{{ $question->id }}]" rows="4" placeholder="اكتب إجابتك هنا..."></textarea>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="submit-section">
            <button type="submit" class="btn-submit-quiz">✅ تسليم التقييم</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
(function () {
    document.querySelectorAll('.q-option[data-question-id]').forEach(function (opt) {
        opt.addEventListener('click', function () {
            var qId = this.getAttribute('data-question-id');
            var container = document.getElementById('qOptions' + qId);
            if (!container) return;

            container.querySelectorAll('.q-option').forEach(function (row) {
                row.classList.remove('selected-neutral');
                var indicator = row.querySelector('.q-opt-indicator');
                if (indicator) indicator.textContent = '';
                var radio = row.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });

            this.classList.add('selected-neutral');
            var selectedIndicator = this.querySelector('.q-opt-indicator');
            if (selectedIndicator) selectedIndicator.textContent = '●';
            var selectedRadio = this.querySelector('input[type="radio"]');
            if (selectedRadio) selectedRadio.checked = true;
        });

        opt.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                this.click();
            }
        });
    });
})();
</script>
@endpush
@endsection
