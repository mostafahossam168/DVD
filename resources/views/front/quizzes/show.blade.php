@extends('front.layouts.front', ['title' => $quiz->title])

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-2">{{ $quiz->title }}</h1>
            <p class="text-muted mb-1">
                {{ $subject->name }} - {{ $subject->grade?->name }} - {{ $subject->grade?->stage?->name }}
            </p>
            <p class="text-muted small mb-3">
                عدد الأسئلة في هذا الاختبار: {{ $questions->count() }}
            </p>

            @if (session('quiz_result'))
                @php($result = session('quiz_result'))
                <div class="alert alert-info">
                    درجتك: {{ $result['score'] }} من {{ $result['max'] }}
                </div>
            @endif

            <form method="POST" action="{{ route('front.quizzes.submit', $quiz) }}">
                @csrf

                @foreach ($questions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-2">
                                سؤال {{ $index + 1 }} (الدرجة: {{ $question->grade }})
                            </h5>
                            <p class="mb-3">{{ $question->question }}</p>

                            @if ($question->type === 'mcq')
                                @foreach ((array) $question->answers as $aIndex => $answer)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio"
                                            name="answers[{{ $question->id }}]"
                                            id="q{{ $question->id }}_{{ $aIndex }}" value="{{ $aIndex }}">
                                        <label class="form-check-label"
                                            for="q{{ $question->id }}_{{ $aIndex }}">
                                            {{ $answer['answer'] ?? '' }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <textarea name="answers_text[{{ $question->id }}]" rows="3" class="form-control"></textarea>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if ($questions->count())
                    <button type="submit" class="btn btn-primary">
                        إرسال الإجابات
                    </button>
                @else
                    <p class="text-muted">لا توجد أسئلة مضافة لهذا الاختبار بعد.</p>
                @endif
            </form>
        </div>
    </section>
@endsection
