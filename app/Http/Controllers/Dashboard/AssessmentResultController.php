<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AssessmentResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_assessment_results', ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $studentId = $request->input('student_id');
        $subjectId = $request->input('subject_id');
        $type = $request->input('type');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = AssessmentResult::with(['user', 'assessment.subject.grade.stage']);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $query->whereHas('assessment', function ($q) {
                $q->where('teacher_id', Auth::id());
            });
        }

        $query
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->whereHas('user', function ($uq) use ($search) {
                        $uq->whereAny(['f_name', 'l_name', 'email', 'phone'], 'LIKE', "%{$search}%");
                    })->orWhereHas('assessment', function ($aq) use ($search) {
                        $aq->where('title', 'LIKE', "%{$search}%");
                    });
                });
            })
            ->when($studentId, fn ($q) => $q->where('user_id', $studentId))
            ->when($type, function ($q) use ($type) {
                $q->whereHas('assessment', fn ($aq) => $aq->where('type', $type));
            })
            ->when($subjectId, function ($q) use ($subjectId) {
                $q->whereHas('assessment', fn ($aq) => $aq->where('subject_id', $subjectId));
            })
            ->when($fromDate, fn ($q) => $q->whereDate('submitted_at', '>=', $fromDate))
            ->when($toDate, fn ($q) => $q->whereDate('submitted_at', '<=', $toDate));

        $results = $query->latest('submitted_at')->latest()->paginate(20);

        $studentsQuery = AssessmentResult::query()
            ->join('users', 'users.id', '=', 'assessment_results.user_id')
            ->select('users.id', 'users.f_name', 'users.l_name', 'users.email')
            ->distinct();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $studentsQuery
                ->join('assessments', 'assessments.id', '=', 'assessment_results.assessment_id')
                ->where('assessments.teacher_id', Auth::id());
        }
        $students = $studentsQuery->orderBy('users.f_name')->get();

        $subjectsQuery = AssessmentResult::query()
            ->join('assessments', 'assessments.id', '=', 'assessment_results.assessment_id')
            ->join('subjects', 'subjects.id', '=', 'assessments.subject_id')
            ->select('subjects.id', 'subjects.name')
            ->distinct();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $subjectsQuery->where('assessments.teacher_id', Auth::id());
        }
        $subjects = $subjectsQuery->orderBy('subjects.name')->get();

        $typesQuery = AssessmentResult::query()
            ->join('assessments', 'assessments.id', '=', 'assessment_results.assessment_id')
            ->select('assessments.type')
            ->whereNotNull('assessments.type')
            ->distinct();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $typesQuery->where('assessments.teacher_id', Auth::id());
        }
        $types = $typesQuery->orderBy('assessments.type')->pluck('assessments.type');

        return view('dashboard.assessment-results.index', compact('results', 'students', 'subjects', 'types'));
    }

    public function show(string $id)
    {
        $result = AssessmentResult::with(['user', 'assessment.subject.grade.stage', 'assessment.questions'])
            ->findOrFail($id);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            if ((int) ($result->assessment?->teacher_id ?? 0) !== (int) Auth::id()) {
                abort(403, 'غير مصرح لك بعرض هذه النتيجة');
            }
        }

        $assessment = $result->assessment;
        $subject = $assessment?->subject;
        $questions = $assessment?->questions ?? collect();
        $detailsByQuestion = collect($result->details ?? [])->keyBy('question_id');

        return view('dashboard.assessment-results.show', compact('result', 'assessment', 'subject', 'questions', 'detailsByQuestion'));
    }
}
