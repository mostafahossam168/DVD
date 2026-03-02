<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Quize;
use App\Models\Subscription;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Quize $quiz)
    {
        abort_unless($quiz->status, 404);

        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $quiz->load(['lecture.subject.grade.stage', 'questions' => function ($q) {
            $q->active();
        }]);

        $subject = $quiz->lecture?->subject;

        if (! $subject || ! $subject->status) {
            abort(404);
        }

        $hasActiveSubscription = Subscription::active()
            ->where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (! $hasActiveSubscription) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'يجب الاشتراك في الكورس أولاً لحل هذا الاختبار.');
        }

        $existingResult = QuizResult::where('user_id', $user->id)
            ->where('quize_id', $quiz->id)
            ->first();

        if ($existingResult) {
            return redirect()->route('front.quizzes.review', $quiz);
        }

        return view('front.quizzes.show', [
            'quiz' => $quiz,
            'subject' => $subject,
            'questions' => $quiz->questions,
        ]);
    }

    public function submit(Request $request, Quize $quiz)
    {
        abort_unless($quiz->status, 404);

        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $quiz->load(['lecture.subject', 'questions' => function ($q) {
            $q->active();
        }]);

        $subject = $quiz->lecture?->subject;

        if (! $subject || ! $subject->status) {
            abort(404);
        }

        $hasActiveSubscription = Subscription::active()
            ->where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (! $hasActiveSubscription) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'يجب الاشتراك في الكورس أولاً لحل هذا الاختبار.');
        }

        // منع إعادة الإرسال لنفس الاختبار
        $existingResult = QuizResult::where('user_id', $user->id)
            ->where('quize_id', $quiz->id)
            ->first();

        if ($existingResult) {
            return redirect()
                ->route('front.quizzes.history')
                ->with('error', 'لقد قمت بحل هذا الاختبار من قبل، لا يمكن دخوله مرة أخرى.');
        }

        $answersMcq = $request->input('answers', []);
        $answersText = $request->input('answers_text', []);

        $score = 0;
        $maxScore = 0;
        $details = [];

        foreach ($quiz->questions as $question) {
            $maxScore += $question->grade;

            if ($question->type === 'mcq') {
                $selectedIndex = isset($answersMcq[$question->id]) ? (int) $answersMcq[$question->id] : null;
                $answers = is_array($question->answers)
                    ? $question->answers
                    : (json_decode($question->answers, true) ?: []);

                $isCorrect = false;
                if ($selectedIndex !== null && isset($answers[$selectedIndex])) {
                    $isCorrect = ! empty($answers[$selectedIndex]['is_correct']);
                }

                if ($isCorrect) {
                    $score += $question->grade;
                }

                $details[] = [
                    'question_id' => $question->id,
                    'type' => 'mcq',
                    'selected_index' => $selectedIndex,
                    'is_correct' => $isCorrect,
                    'grade' => $question->grade,
                ];
            } else {
                $studentAnswer = (string) ($answersText[$question->id] ?? '');
                $isCorrect = false;

                if ($studentAnswer !== null && $question->correct_answer) {
                    $normalizedStudent = trim(mb_strtolower($studentAnswer));
                    $normalizedCorrect = trim(mb_strtolower($question->correct_answer));

                    if ($normalizedStudent === $normalizedCorrect) {
                        $isCorrect = true;
                        $score += $question->grade;
                    }
                }

                $details[] = [
                    'question_id' => $question->id,
                    'type' => 'text',
                    'answer' => $studentAnswer,
                    'is_correct' => $isCorrect,
                    'grade' => $question->grade,
                ];
            }
        }

        QuizResult::create([
            'user_id' => $user->id,
            'quize_id' => $quiz->id,
            'score' => $score,
            'max_score' => $maxScore,
            'details' => $details,
        ]);

        return back()->with([
            'quiz_result' => [
                'score' => $score,
                'max' => $maxScore,
            ],
        ]);
    }

    public function review(Quize $quiz)
    {
        abort_unless($quiz->status, 404);

        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $quiz->load(['lecture.subject.grade.stage', 'questions' => function ($q) {
            $q->active();
        }]);

        $subject = $quiz->lecture?->subject;

        if (! $subject || ! $subject->status) {
            abort(404);
        }

        $result = QuizResult::where('user_id', $user->id)
            ->where('quize_id', $quiz->id)
            ->first();

        if (! $result) {
            return redirect()->route('front.quizzes.show', $quiz);
        }

        $detailsByQuestion = collect($result->details ?? [])->keyBy('question_id');

        return view('front.quizzes.review', [
            'quiz' => $quiz,
            'subject' => $subject,
            'questions' => $quiz->questions,
            'result' => $result,
            'detailsByQuestion' => $detailsByQuestion,
        ]);
    }

    public function history()
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $results = QuizResult::with(['quiz.lecture.subject.grade.stage'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('front.quizzes.history', compact('results'));
    }
}

