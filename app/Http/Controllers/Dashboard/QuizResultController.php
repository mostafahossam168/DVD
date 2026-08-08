<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_quiz_results', ['only' => ['index', 'show']]);
    }

    public function index()
    {
        $query = QuizResult::with(['user', 'quiz.lecture.subject.grade.stage']);

        $results = $query->latest()->paginate(20);

        return view('dashboard.quiz-results.index', compact('results'));
    }

    public function show(string $id)
    {
        $result = QuizResult::with(['user', 'quiz.lecture.subject.grade.stage'])->findOrFail($id);

        $quiz = $result->quiz;
        $subject = $quiz?->lecture?->subject;

        $questions = $quiz?->questions()->active()->get() ?? collect();
        $detailsByQuestion = collect($result->details ?? [])->keyBy('question_id');

        return view('dashboard.quiz-results.show', compact('result', 'quiz', 'subject', 'questions', 'detailsByQuestion'));
    }
}
