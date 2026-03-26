<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResult;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function history()
    {
        $user = Auth::user();
        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $results = AssessmentResult::with(['assessment.subject.grade.stage'])
            ->where('user_id', $user->id)
            ->latest('submitted_at')
            ->latest()
            ->paginate(20);

        $all = AssessmentResult::where('user_id', $user->id)->count();
        $passed = AssessmentResult::where('user_id', $user->id)
            ->whereRaw('max_score > 0 AND ((score * 100.0) / max_score) >= 50')
            ->count();
        $failed = max($all - $passed, 0);

        $stats = [
            'all' => $all,
            'passed' => $passed,
            'failed' => $failed,
        ];

        return view('front.assessments.history', compact('results', 'stats'));
    }

    public function show(Assessment $assessment)
    {
        abort_unless($assessment->status, 404);

        $user = Auth::user();
        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $this->ensureAvailability($assessment);
        $this->ensureSubscription($assessment, $user->id);

        $assessment->load(['subject.grade.stage', 'questions' => function ($q) {
            $q->active();
        }]);

        $existingResult = AssessmentResult::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->first();

        if ($existingResult) {
            return redirect()->route('front.assessments.review', $assessment);
        }

        return view('front.assessments.show', [
            'assessment' => $assessment,
            'questions' => $assessment->questions,
        ]);
    }

    public function submit(Request $request, Assessment $assessment)
    {
        abort_unless($assessment->status, 404);

        $user = Auth::user();
        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $this->ensureAvailability($assessment);
        $this->ensureSubscription($assessment, $user->id);

        $assessment->load(['questions' => function ($q) {
            $q->active();
        }]);

        $existingResult = AssessmentResult::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->first();
        if ($existingResult) {
            return redirect()->route('front.assessments.review', $assessment)
                ->with('error', 'لقد قمت بحل هذا التقييم من قبل.');
        }

        $answersMcq = $request->input('answers', []);
        $answersText = $request->input('answers_text', []);

        $score = 0;
        $maxScore = 0;
        $details = [];

        foreach ($assessment->questions as $question) {
            $mark = (int) ($question->pivot->mark ?? $question->default_mark ?? 1);
            $maxScore += $mark;

            if ($question->type === 'mcq') {
                $selectedIndex = isset($answersMcq[$question->id]) ? (int) $answersMcq[$question->id] : null;
                $answers = is_array($question->answers) ? $question->answers : (json_decode($question->answers ?? '[]', true) ?: []);

                $isCorrect = false;
                if ($selectedIndex !== null && isset($answers[$selectedIndex])) {
                    $isCorrect = ! empty($answers[$selectedIndex]['is_correct']);
                }

                if ($isCorrect) {
                    $score += $mark;
                }

                $details[] = [
                    'question_id' => $question->id,
                    'type' => 'mcq',
                    'selected_index' => $selectedIndex,
                    'is_correct' => $isCorrect,
                    'mark' => $mark,
                ];
            } else {
                $studentAnswer = (string) ($answersText[$question->id] ?? '');
                $normalizedStudent = trim(mb_strtolower($studentAnswer));
                $normalizedCorrect = trim(mb_strtolower((string) $question->correct_answer));
                $isCorrect = $normalizedStudent !== '' && $normalizedCorrect !== '' && $normalizedStudent === $normalizedCorrect;

                if ($isCorrect) {
                    $score += $mark;
                }

                $details[] = [
                    'question_id' => $question->id,
                    'type' => $question->type,
                    'answer' => $studentAnswer,
                    'is_correct' => $isCorrect,
                    'mark' => $mark,
                ];
            }
        }

        AssessmentResult::create([
            'user_id' => $user->id,
            'assessment_id' => $assessment->id,
            'score' => $score,
            'max_score' => $maxScore,
            'details' => $details,
            'submitted_at' => now(),
        ]);

        return redirect()->route('front.assessments.review', $assessment)->with('success', 'تم تسليم التقييم بنجاح.');
    }

    public function review(Assessment $assessment)
    {
        abort_unless($assessment->status, 404);

        $user = Auth::user();
        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        $this->ensureSubscription($assessment, $user->id);

        $assessment->load(['subject.grade.stage', 'questions' => function ($q) {
            $q->active();
        }]);

        $result = AssessmentResult::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->first();

        if (! $result) {
            return redirect()->route('front.assessments.show', $assessment);
        }

        $detailsByQuestion = collect($result->details ?? [])->keyBy('question_id');

        return view('front.assessments.review', [
            'assessment' => $assessment,
            'questions' => $assessment->questions,
            'result' => $result,
            'detailsByQuestion' => $detailsByQuestion,
        ]);
    }

    protected function ensureSubscription(Assessment $assessment, int $userId): void
    {
        $hasSubscription = Subscription::active()
            ->where('user_id', $userId)
            ->where('subject_id', $assessment->subject_id)
            ->exists();

        abort_unless($hasSubscription, 403, 'يجب الاشتراك في الكورس أولاً.');
    }

    protected function ensureAvailability(Assessment $assessment): void
    {
        $now = now();
        if ($assessment->start_time && $now->lt($assessment->start_time)) {
            abort(403, 'التقييم لم يبدأ بعد.');
        }
        if ($assessment->end_time && $now->gt($assessment->end_time)) {
            abort(403, 'انتهى وقت التقييم.');
        }
    }
}
