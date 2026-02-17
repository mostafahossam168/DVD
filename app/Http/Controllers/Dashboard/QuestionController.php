<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Question;
use App\Models\Quize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_questions|create_questions|update_questions|delete_questions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_questions', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_questions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_questions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $type = request('type');
        $quize_id = request('quize_id');

        $query = Question::query();

        // إذا كان المستخدم مدرس (وليس admin)، يعرض فقط الأسئلة للاختبارات الخاصة بالمواد الخاصة به
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->whereHas('quize.lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            });
        }

        $items = $query->when($search, function ($q) use ($search) {
            $q->where('question', 'LIKE', "%$search%");
        })->when($quize_id, function ($q) use ($quize_id) {
            $q->where('quize_id', $quize_id);
        })->when($type, function ($q) use ($type) {
            $q->where('type', $type);
        })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(30);

        $count_all = $query->count();
        $count_active = (clone $query)->active()->count();
        $count_inactive = (clone $query)->inactive()->count();

        // جلب الاختبارات للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $quizes = Quize::whereHas('lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->get();
        } else {
            $quizes = Quize::get();
        }

        return view('dashboard.questions.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'quizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // جلب الاختبارات للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $quizes = Quize::whereHas('lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->get();
        } else {
            $quizes = Quize::get();
        }

        return view('dashboard.questions.create', compact('quizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|max:255',
            'quize_id' => 'required|exists:quizes,id',
            'status' => 'required|boolean',
            'type' => 'required',
            'grade' => 'required|integer|min:1',
            'correct_answer' => ['nullable', 'required_if:type,text', 'string'],
            'answers' => ['nullable', 'required_if:type,mcq', 'array'],
            'correct_answer_radio' => ['required_if:type,mcq'],
        ]);

        // التحقق من أن المدرس يضيف سؤال لاختبار لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $quize = Quize::with('lecture.subject')->findOrFail($data['quize_id']);
            if (!$quize->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة سؤال لهذا الاختبار');
            }
        }
        if ($request->type === 'mcq') {
            $answers = [];
            foreach ($request->answers as $index => $answerText) {
                $answers[] = [
                    'answer' => $answerText,
                    'is_correct' => ($index + 1) == $request->correct_answer_radio,
                ];
            }
            $data['answers'] = $answers;
            $data['correct_answer'] = null; // نص مستبعد
        } else {
            // سؤال نصي
            $data['correct_answer'] = $request->correct_answer;
            $data['answers'] = null;
        }
        Question::create($data);
        return redirect()->route('dashboard.questions.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Question::with(['quize.lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يعدل سؤال لاختبار لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->quize->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا السؤال');
            }
        }

        // جلب الاختبارات للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $quizes = Quize::whereHas('lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->get();
        } else {
            $quizes = Quize::get();
        }

        return view('dashboard.questions.edit', compact('item', 'quizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Question::with(['quize.lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يعدل سؤال لاختبار لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->quize->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا السؤال');
            }
        }

        $data = $request->validate([
            'question' => 'required|max:255',
            'quize_id' => 'required|exists:quizes,id',
            'status' => 'required|boolean',
            'type' => 'required',
            'grade' => 'required|integer|min:1',
            'correct_answer' => ['nullable', 'required_if:type,text', 'string'],
            'answers' => ['nullable', 'required_if:type,mcq', 'array'],
            'correct_answer_radio' => ['required_if:type,mcq'],
        ]);

        // التحقق من أن المدرس يضيف سؤال لاختبار لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $quize = Quize::with('lecture.subject')->findOrFail($data['quize_id']);
            if (!$quize->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة سؤال لهذا الاختبار');
            }
        }
        if ($request->type === 'mcq') {
            $answers = [];
            foreach ($request->answers as $index => $answerText) {
                $answers[] = [
                    'answer' => $answerText,
                    'is_correct' => ($index + 1) == $request->correct_answer_radio,
                ];
            }
            $data['answers'] = $answers;
            $data['correct_answer'] = null; // نص مستبعد
        } else {
            // سؤال نصي
            $data['correct_answer'] = $request->correct_answer;
            $data['answers'] = null;
        }
        $item->update($data);
        return redirect()->route('dashboard.questions.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Question::with(['quize.lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يحذف سؤال لاختبار لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->quize->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بحذف هذا السؤال');
            }
        }

        $item->delete();
        return redirect()->route('dashboard.questions.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
