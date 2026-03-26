<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Stage;
use App\Models\Assessment;
use App\Models\QuestionBankQuestion;
use Illuminate\Support\Facades\Auth;
use App\Services\AssessmentQuestionService;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\StoreAssessmentRequest;
use App\Http\Requests\Dashboard\UpdateAssessmentRequest;
use App\Http\Requests\Dashboard\AttachAssessmentQuestionsRequest;

class AssessmentController extends Controller
{
    public function __construct(private readonly AssessmentQuestionService $assessmentQuestionService)
    {
        $this->middleware('permission:read_assessments|create_assessments|update_assessments|delete_assessments', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_assessments', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_assessments', ['only' => ['edit', 'update', 'attachQuestions', 'syncQuestions']]);
        $this->middleware('permission:delete_assessments', ['only' => ['destroy']]);
    }

    public function index()
    {
        $query = Assessment::with(['teacher', 'stage', 'grade', 'subject', 'questions.categories']);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $query->where('teacher_id', Auth::id());
        }

        $search = request('search');
        $type = request('type');
        $status = request('status');

        $items = $query
            ->when($search, fn ($q) => $q->where('title', 'LIKE', "%$search%"))
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($status, function ($q) use ($status) {
                if ($status === 'yes') {
                    $q->active();
                }
                if ($status === 'no') {
                    $q->inactive();
                }
            })
            ->latest()
            ->paginate(30);

        $count_all = (clone $query)->count();
        $count_active = (clone $query)->active()->count();
        $count_inactive = (clone $query)->inactive()->count();

        return view('dashboard.assessments.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    public function store(StoreAssessmentRequest $request)
    {
        $data = $request->validated();
        $data['teacher_id'] = $this->resolveTeacherId($data['teacher_id'] ?? null);
        $data['status'] = $data['status'] ?? true;

        $assessment = Assessment::create([
            'title' => $data['title'],
            'type' => $data['type'],
            'teacher_id' => $data['teacher_id'],
            'stage_id' => $data['stage_id'],
            'grade_id' => $data['grade_id'],
            'subject_id' => $data['subject_id'],
            'start_time' => $data['start_time'] ?? null,
            'end_time' => $data['end_time'] ?? null,
            'duration' => $data['duration'] ?? null,
            'status' => $data['status'],
        ]);

        if (!empty($data['questions']) || !empty($data['random'])) {
            $payload = $this->assessmentQuestionService->buildSyncPayload($data);
            if (!empty($payload)) {
                $allowedIds = QuestionBankQuestion::query()
                    ->where('teacher_id', $assessment->teacher_id)
                    ->whereIn('id', array_map('intval', array_keys($payload)))
                    ->pluck('id')
                    ->map(fn ($id) => (int) $id)
                    ->all();

                $payload = collect($payload)
                    ->filter(fn ($pivotData, $questionId) => in_array((int) $questionId, $allowedIds, true))
                    ->all();
            }
            $assessment->questions()->sync($payload);
        }

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function create()
    {
        $teachers = User::teachers()->active()->get();
        $stages = Stage::with(['grades.subjects'])->active()->get();
        $questionsQuery = QuestionBankQuestion::with('categories')->active();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $questionsQuery->where('teacher_id', Auth::id());
        }
        $allQuestions = $questionsQuery->latest()->get();

        return view('dashboard.assessments.create', compact('teachers', 'allQuestions', 'stages'));
    }

    public function show(string $id)
    {
        $assessment = Assessment::with(['teacher', 'stage', 'grade', 'subject', 'questions.categories'])->findOrFail($id);
        $this->authorizeAssessment($assessment);

        return view('dashboard.assessments.show', compact('assessment'));
    }

    public function update(UpdateAssessmentRequest $request, string $id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorizeAssessment($assessment);

        $data = $request->validated();
        $data['teacher_id'] = $this->resolveTeacherId($data['teacher_id'] ?? $assessment->teacher_id);

        $assessment->update($data);

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function edit(string $id)
    {
        $item = Assessment::with(['questions.categories'])->findOrFail($id);
        $this->authorizeAssessment($item);

        $stages = Stage::with(['grades.subjects'])->active()->get();
        $questionsQuery = QuestionBankQuestion::with('categories')->active();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $questionsQuery->where('teacher_id', Auth::id());
        } elseif (Auth::user()->type === 'admin') {
            $questionsQuery->where('teacher_id', $item->teacher_id);
        }
        $allQuestions = $questionsQuery->latest()->get();

        $teachers = User::teachers()->active()->get();

        return view('dashboard.assessments.edit', compact('item', 'allQuestions', 'teachers', 'stages'));
    }

    public function destroy(string $id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorizeAssessment($assessment);
        $assessment->delete();

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم حذف البيانات بنجاح');
    }

    public function attachQuestions(AttachAssessmentQuestionsRequest $request, string $id)
    {
        $assessment = Assessment::with('questions')->findOrFail($id);
        $this->authorizeAssessment($assessment);

        $payload = $this->assessmentQuestionService->buildSyncPayload($request->validated());
        $this->assessmentQuestionService->attachWithoutDuplicates($assessment, $payload);
        return redirect()->route('dashboard.assessments.edit', $assessment->id)->with('success', 'تم إضافة الأسئلة بنجاح');
    }

    public function syncQuestions(AttachAssessmentQuestionsRequest $request, string $id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorizeAssessment($assessment);

        $payload = $this->assessmentQuestionService->buildSyncPayload($request->validated());
        $assessment->questions()->sync($payload);
        return redirect()->route('dashboard.assessments.edit', $assessment->id)->with('success', 'تم مزامنة الأسئلة بنجاح');
    }

    protected function authorizeAssessment(Assessment $assessment): void
    {
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin') && $assessment->teacher_id !== Auth::id()) {
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
}
