<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreQuestionBankQuestionRequest;
use App\Http\Requests\Dashboard\UpdateQuestionBankQuestionRequest;
use App\Models\Stage;
use App\Models\QuestionBankQuestion;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_question_bank|create_question_bank|update_question_bank|delete_question_bank', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_question_bank', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_question_bank', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_question_bank', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = QuestionBankQuestion::with(['teacher', 'categories', 'stage', 'grade', 'subject']);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $query->where('teacher_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('status')) {
            if ($request->status === 'yes') {
                $query->active();
            } elseif ($request->status === 'no') {
                $query->inactive();
            }
        }

        $items = $query->latest()->paginate(30);
        $count_all = (clone $query)->count();
        $count_active = (clone $query)->active()->count();
        $count_inactive = (clone $query)->inactive()->count();
        $categories = QuestionCategory::orderBy('name')->get();

        return view('dashboard.question-bank.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'categories'));
    }

    public function store(StoreQuestionBankQuestionRequest $request)
    {
        $data = $request->validated();
        $data['teacher_id'] = $this->resolveTeacherId($data['teacher_id'] ?? null);
        $this->ensureAcademicChain($data);
        $data['status'] = $data['status'] ?? true;

        $question = QuestionBankQuestion::create([
            'question_text' => $data['question_text'],
            'answers' => $this->prepareAnswers($data),
            'correct_answer' => $this->prepareCorrectAnswer($data),
            'type' => $data['type'],
            'default_mark' => $data['default_mark'] ?? null,
            'difficulty' => $data['difficulty'] ?? 'medium',
            'teacher_id' => $data['teacher_id'],
            'stage_id' => $data['stage_id'],
            'grade_id' => $data['grade_id'],
            'subject_id' => $data['subject_id'],
            'status' => $data['status'],
        ]);

        $this->syncCategories($question, $data);
        $question->load('categories');

        return redirect()->route('dashboard.question-bank.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function create()
    {
        $categories = QuestionCategory::orderBy('name')->get();
        $teachers = User::teachers()->active()->get();
        $stages = Stage::query()
            ->with(['grades' => function ($q) {
                $q->with('subjects')->active();
            }])
            ->active()
            ->get();

        return view('dashboard.question-bank.create', compact('categories', 'teachers', 'stages'));
    }

    public function show(string $id)
    {
        $question = QuestionBankQuestion::with(['teacher', 'categories', 'stage', 'grade', 'subject'])->findOrFail($id);
        $this->authorizeQuestion($question);

        return view('dashboard.question-bank.show', compact('question'));
    }

    public function update(UpdateQuestionBankQuestionRequest $request, string $id)
    {
        $question = QuestionBankQuestion::findOrFail($id);
        $this->authorizeQuestion($question);

        $data = $request->validated();
        $data['teacher_id'] = $this->resolveTeacherId($data['teacher_id'] ?? $question->teacher_id);
        $this->ensureAcademicChain($data);

        $question->update([
            'question_text' => $data['question_text'],
            'answers' => $this->prepareAnswers($data),
            'correct_answer' => $this->prepareCorrectAnswer($data),
            'type' => $data['type'],
            'default_mark' => $data['default_mark'] ?? null,
            'difficulty' => $data['difficulty'] ?? 'medium',
            'teacher_id' => $data['teacher_id'],
            'stage_id' => $data['stage_id'],
            'grade_id' => $data['grade_id'],
            'subject_id' => $data['subject_id'],
            'status' => $data['status'],
        ]);

        $this->syncCategories($question, $data);
        $question->load('categories');

        return redirect()->route('dashboard.question-bank.index')->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function edit(string $id)
    {
        $item = QuestionBankQuestion::with('categories')->findOrFail($id);
        $this->authorizeQuestion($item);
        $categories = QuestionCategory::orderBy('name')->get();
        $teachers = User::teachers()->active()->get();
        $stages = Stage::query()
            ->with(['grades' => function ($q) {
                $q->with('subjects')->active();
            }])
            ->active()
            ->get();

        return view('dashboard.question-bank.edit', compact('item', 'categories', 'teachers', 'stages'));
    }

    public function destroy(string $id)
    {
        $question = QuestionBankQuestion::findOrFail($id);
        $this->authorizeQuestion($question);
        $question->delete();

        return redirect()->route('dashboard.question-bank.index')->with('success', 'تم حذف البيانات بنجاح');
    }

    protected function syncCategories(QuestionBankQuestion $question, array $data): void
    {
        $categoryIds = collect($data['category_ids'] ?? []);

        if (!empty($data['categories'])) {
            $created = collect($data['categories'])
                ->filter(fn($name) => filled($name))
                ->map(function ($name) {
                    return QuestionCategory::firstOrCreate([
                        'name' => trim($name),
                    ])->id;
                });

            $categoryIds = $categoryIds->merge($created);
        }

        $question->categories()->sync($categoryIds->unique()->values()->all());
    }

    protected function authorizeQuestion(QuestionBankQuestion $question): void
    {
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin') && $question->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
    }

    protected function resolveTeacherId(?int $teacherId): int
    {
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            return Auth::id();
        }

        if ($teacherId) {
            $teacher = User::where('id', $teacherId)->where('type', 'teacher')->firstOrFail();

            return $teacher->id;
        }

        return Auth::id();
    }

    protected function prepareAnswers(array $data): ?array
    {
        if (($data['type'] ?? null) !== 'mcq') {
            return null;
        }

        $answers = collect($data['answers'] ?? [])
            ->map(fn ($answer) => trim((string) $answer))
            ->filter()
            ->values();

        if ($answers->isEmpty()) {
            return null;
        }

        $correctIndex = max(((int) ($data['correct_answer_radio'] ?? 1)) - 1, 0);

        return $answers->map(function (string $answer, int $index) use ($correctIndex) {
            return [
                'answer' => $answer,
                'is_correct' => $index === $correctIndex,
            ];
        })->all();
    }

    protected function prepareCorrectAnswer(array $data): ?string
    {
        if (($data['type'] ?? null) === 'mcq') {
            $answers = $this->prepareAnswers($data);
            if (empty($answers)) {
                return null;
            }

            foreach ($answers as $answer) {
                if (!empty($answer['is_correct'])) {
                    return (string) $answer['answer'];
                }
            }

            return null;
        }

        if (($data['type'] ?? null) === 'true_false') {
            return in_array(($data['correct_answer'] ?? ''), ['true', 'false'], true) ? $data['correct_answer'] : null;
        }

        return isset($data['correct_answer']) ? trim((string) $data['correct_answer']) : null;
    }

    protected function ensureAcademicChain(array $data): void
    {
        $stage = Stage::query()
            ->with(['grades' => function ($q) {
                $q->with('subjects');
            }])
            ->findOrFail($data['stage_id']);

        $grade = $stage->grades->firstWhere('id', (int) $data['grade_id']);
        if (! $grade) {
            abort(422, 'الصف غير تابع للمرحلة المختارة.');
        }

        $subject = $grade->subjects->firstWhere('id', (int) $data['subject_id']);
        if (! $subject) {
            abort(422, 'المادة غير تابعة للصف المختار.');
        }
    }
}
