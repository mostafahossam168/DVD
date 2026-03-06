@extends('front.layouts.front', ['title' => 'فاهم — ' . $quiz->title])

@section('content')
@php
    $durationMinutes = (int) ($quiz->duration_minutes ?? 60);
    $totalScore = $questions->sum('grade');
    $subject = $quiz->lecture?->subject;
    $grade = $subject?->grade;
    $stage = $grade?->stage;
    $totalQ = $questions->count();
@endphp

{{-- Progress bar (sticky) --}}
<div class="quiz-progress-bar" id="quizProgressBar">
    <div class="quiz-progress-inner">
        <span class="progress-label">التقدم في الاختبار</span>
        <div class="progress-track">
            <div class="progress-fill" id="quizProgressFill" style="width:0%"></div>
        </div>
        <span class="progress-count" id="quizProgressCount">٠ / {{ $totalQ }}</span>
        <div class="progress-timer" id="quizTimer">
            <div class="timer-dot"></div>
            <span id="quizTimerDisplay">--:--</span>
        </div>
    </div>
</div>

<div class="quiz-page-wrap">
    {{-- Quiz header --}}
    <div class="quiz-header">
        <div class="quiz-eyebrow">📝 اختبار</div>
        <h1 class="quiz-title">{{ $quiz->title }}</h1>
        <div class="quiz-meta">{{ $subject?->name ?? '' }} — {{ $grade?->name ?? '' }} — {{ $stage?->name ?? '' }}</div>
        <div class="quiz-stats">
            <div class="quiz-stat">
                <span class="quiz-stat-val">{{ $totalQ }}</span>
                <span class="quiz-stat-label">سؤال</span>
            </div>
            <div class="quiz-stat">
                <span class="quiz-stat-val">{{ $totalScore }}</span>
                <span class="quiz-stat-label">درجة كاملة</span>
            </div>
            <div class="quiz-stat">
                <span class="quiz-stat-val" id="headerScore">—</span>
                <span class="quiz-stat-label">درجتك</span>
            </div>
            <div class="quiz-stat">
                <span class="quiz-stat-val">{{ $durationMinutes }} دقيقة</span>
                <span class="quiz-stat-label">الوقت</span>
            </div>
        </div>
    </div>

    @if($questions->isEmpty())
        <div class="submit-section">
            <p class="submit-sub">لا توجد أسئلة مضافة لهذا الاختبار بعد.</p>
            <a href="{{ route('front.courses.subject', $subject) }}" class="btn-submit-quiz" style="text-decoration:none">العودة للكورس</a>
        </div>
    @else
        <form method="POST" action="{{ route('front.quizzes.submit', $quiz) }}" id="quizForm">
            @csrf

            @foreach($questions as $index => $question)
                @php
                    $qNum = $index + 1;
                    $answersArray = is_array($question->answers) ? $question->answers : (json_decode($question->answers ?? '[]', true) ?: []);
                @endphp
                <div class="question-card" id="qCard{{ $question->id }}">
                    <div class="q-card-header">
                        <div class="q-num-badge badge-neutral" id="qBadge{{ $question->id }}">{{ $qNum }}</div>
                        <div class="q-header-text">
                            <div class="q-title">سؤال {{ $qNum }}</div>
                            <div class="q-points-row">
                                <span class="q-points points-neutral" id="qPoints{{ $question->id }}">{{ $question->grade }} درجات</span>
                                <span class="q-status-chip chip-unanswered" id="qChip{{ $question->id }}">لم تجب بعد</span>
                            </div>
                        </div>
                    </div>
                    <div class="q-card-body">
                        <div class="q-text">{{ $question->question }}</div>

                        @if($question->type === 'mcq')
                            <div class="q-options" id="qOptions{{ $question->id }}">
                                @foreach($answersArray as $aIndex => $answer)
                                    <div class="q-option" data-question-id="{{ $question->id }}" data-index="{{ $aIndex }}" role="button" tabindex="0">
                                        <div class="q-opt-indicator"></div>
                                        <span class="q-opt-label">{{ $answer['answer'] ?? '' }}</span>
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $aIndex }}" class="d-none" data-question-id="{{ $question->id }}">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-answer-wrap">
                                <textarea class="text-answer-box" name="answers_text[{{ $question->id }}]" id="textAnswer{{ $question->id }}" placeholder="اكتب إجابتك هنا..." rows="4" data-question-id="{{ $question->id }}"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Submit section --}}
            <div class="submit-section" id="submitSection">
                <div class="submit-title">📤 تسليم الاختبار</div>
                <div class="submit-sub">راجع إجاباتك قبل التسليم. بعد التسليم لن تتمكن من التعديل.</div>
                <div class="submit-summary">
                    <div class="submit-stat answered">
                        <span class="submit-stat-val" id="answeredCount">٠</span>
                        <span class="submit-stat-label">أجبت عليها</span>
                    </div>
                    <div class="submit-stat unanswered">
                        <span class="submit-stat-val" id="unansweredCount">{{ $totalQ }}</span>
                        <span class="submit-stat-label">لم تجب بعد</span>
                    </div>
                    <div class="submit-stat total">
                        <span class="submit-stat-val">{{ $totalQ }}</span>
                        <span class="submit-stat-label">إجمالي الأسئلة</span>
                    </div>
                </div>
                <button type="button" class="btn-submit-quiz" id="btnSubmitQuiz">
                    <span>✅</span> تسليم الاختبار
                </button>
            </div>
        </form>
    @endif
</div>

{{-- Confirm modal --}}
<div class="quiz-modal-overlay" id="confirmModal" onclick="quizCloseConfirm(event)">
    <div class="quiz-modal" onclick="event.stopPropagation()">
        <div class="quiz-modal-icon">📋</div>
        <div class="quiz-modal-title">هل أنت متأكد من التسليم؟</div>
        <div class="quiz-modal-text" id="confirmText">لديك <strong id="unansweredModal">٠</strong> أسئلة لم تجب عليها. بعد التسليم لن تتمكن من تعديل إجاباتك.</div>
        <div class="quiz-modal-actions">
            <button type="button" class="btn-modal-confirm" id="btnConfirmSubmit">نعم، سلّم الاختبار</button>
            <button type="button" class="btn-modal-cancel" onclick="quizCloseConfirm()">مراجعة الإجابات</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
  var totalQ = {{ $totalQ }};
  var totalScore = {{ $totalScore }};
  var durationMinutes = {{ $durationMinutes }};
  var timeLeft = durationMinutes * 60;
  var timerInterval;
  var submitted = false;

  function toArabicNum(n) {
    return String(n).replace(/\d/g, function(d) { return '٠١٢٣٤٥٦٧٨٩'[d]; });
  }

  function updateProgress() {
    var answered = 0;
    document.querySelectorAll('[name^="answers["], [name^="answers_text["]').forEach(function(inp) {
      if (inp.tagName === 'TEXTAREA') {
        if (inp.value.trim()) answered++;
      } else if (inp.checked) answered++;
    });
    var pct = totalQ ? Math.round(answered / totalQ * 100) : 0;
    var fill = document.getElementById('quizProgressFill');
    var count = document.getElementById('quizProgressCount');
    if (fill) fill.style.width = pct + '%';
    if (count) count.textContent = toArabicNum(answered) + ' / ' + toArabicNum(totalQ);
    var ac = document.getElementById('answeredCount');
    var uc = document.getElementById('unansweredCount');
    if (ac) ac.textContent = toArabicNum(answered);
    if (uc) uc.textContent = toArabicNum(totalQ - answered);
  }

  function updateChip(questionId, state) {
    var chip = document.getElementById('qChip' + questionId);
    if (!chip) return;
    if (state === 'answered') {
      chip.textContent = '✓ تمت الإجابة';
      chip.className = 'q-status-chip chip-correct';
    } else {
      chip.textContent = 'لم تجب بعد';
      chip.className = 'q-status-chip chip-unanswered';
    }
  }

  // MCQ click
  document.querySelectorAll('.q-option[data-question-id]').forEach(function(opt) {
    opt.addEventListener('click', function() {
      if (submitted) return;
      var qId = this.getAttribute('data-question-id');
      var container = document.getElementById('qOptions' + qId);
      if (!container) return;
      container.querySelectorAll('.q-option').forEach(function(o) {
        o.classList.remove('selected-neutral');
        o.querySelector('.q-opt-indicator').textContent = '';
      });
      this.classList.add('selected-neutral');
      this.querySelector('.q-opt-indicator').textContent = '●';
      var radio = this.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;
      updateProgress();
      updateChip(qId, 'answered');
    });
  });

  // Text answers
  document.querySelectorAll('.text-answer-box[data-question-id]').forEach(function(ta) {
    ta.addEventListener('input', function() {
      if (submitted) return;
      var qId = this.getAttribute('data-question-id');
      updateProgress();
      updateChip(qId, this.value.trim() ? 'answered' : 'unanswered');
    });
  });

  // Timer
  function startTimer() {
    function display() {
      var m = Math.floor(timeLeft / 60);
      var s = timeLeft % 60;
      var el = document.getElementById('quizTimerDisplay');
      if (el) el.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
      var timerEl = document.getElementById('quizTimer');
      if (timeLeft <= 60 && timerEl) {
        timerEl.style.background = '#FEF2F2';
        timerEl.style.borderColor = '#FECACA';
        timerEl.style.color = '#991B1B';
      }
      if (timeLeft <= 0) {
        clearInterval(timerInterval);
        if (!submitted) document.getElementById('quizForm') && document.getElementById('quizForm').submit();
      }
    }
    display();
    timerInterval = setInterval(function() {
      if (submitted) { clearInterval(timerInterval); return; }
      timeLeft--;
      display();
      if (timeLeft <= 0) {
        clearInterval(timerInterval);
        if (!submitted) document.getElementById('quizForm') && document.getElementById('quizForm').submit();
      }
    }, 1000);
  }
  startTimer();

  // Submit button -> confirm modal
  document.getElementById('btnSubmitQuiz') && document.getElementById('btnSubmitQuiz').addEventListener('click', function() {
    var answered = 0;
    document.querySelectorAll('[name^="answers["], [name^="answers_text["]').forEach(function(inp) {
      if (inp.tagName === 'TEXTAREA') { if (inp.value.trim()) answered++; }
      else if (inp.checked) answered++;
    });
    var unanswered = totalQ - answered;
    document.getElementById('unansweredModal').textContent = toArabicNum(unanswered);
    document.getElementById('confirmModal').classList.add('show');
  });

  window.quizCloseConfirm = function(e) {
    if (!e || e.target === document.getElementById('confirmModal'))
      document.getElementById('confirmModal').classList.remove('show');
  };

  document.getElementById('btnConfirmSubmit') && document.getElementById('btnConfirmSubmit').addEventListener('click', function() {
    submitted = true;
    clearInterval(timerInterval);
    document.getElementById('confirmModal').classList.remove('show');
    var form = document.getElementById('quizForm');
    if (form) form.submit();
  });

  updateProgress();
})();
</script>
@endpush
@endsection
