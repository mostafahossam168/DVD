<?php

namespace App\Http\Controllers\Dashboard;

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
        $data['status'] = $data['status'] ?? true;

        $assessment = Assessment::create([
            'title' => $data['title'],
            'type' => $data['type'],
            'teacher_id' => Auth::id(),
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
            $assessment->questions()->sync($payload);
        }

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function create()
    {
        $stages = Stage::with(['grades.subjects'])->active()->get();
        $allQuestions = QuestionBankQuestion::with('categories')->active()->latest()->get();

        return view('dashboard.assessments.create', compact('allQuestions', 'stages'));
    }

    public function show(string $id)
    {
        $assessment = Assessment::with(['teacher', 'stage', 'grade', 'subject', 'questions.categories'])->findOrFail($id);

        return view('dashboard.assessments.show', compact('assessment'));
    }

    public function update(UpdateAssessmentRequest $request, string $id)
    {
        $assessment = Assessment::findOrFail($id);

        $data = $request->validated();

        $assessment->update($data);

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function edit(string $id)
    {
        $item = Assessment::with(['questions.categories'])->findOrFail($id);

        $stages = Stage::with(['grades.subjects'])->active()->get();
        $allQuestions = QuestionBankQuestion::with('categories')->active()->latest()->get();

        return view('dashboard.assessments.edit', compact('item', 'allQuestions', 'stages'));
    }

    public function destroy(string $id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('dashboard.assessments.index')->with('success', 'تم حذف البيانات بنجاح');
    }

    public function attachQuestions(AttachAssessmentQuestionsRequest $request, string $id)
    {
        $assessment = Assessment::with('questions')->findOrFail($id);

        $payload = $this->assessmentQuestionService->buildSyncPayload($request->validated());
        $this->assessmentQuestionService->attachWithoutDuplicates($assessment, $payload);
        return redirect()->route('dashboard.assessments.edit', $assessment->id)->with('success', 'تم إضافة الأسئلة بنجاح');
    }

    public function syncQuestions(AttachAssessmentQuestionsRequest $request, string $id)
    {
        $assessment = Assessment::findOrFail($id);

        $payload = $this->assessmentQuestionService->buildSyncPayload($request->validated());
        $assessment->questions()->sync($payload);
        return redirect()->route('dashboard.assessments.edit', $assessment->id)->with('success', 'تم مزامنة الأسئلة بنجاح');
    }
}
