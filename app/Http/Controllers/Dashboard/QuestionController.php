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
        $items = Question::when($search, function ($q) use ($search) {
            $q->where('title', 'LIKE', "%$search%");
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

        $count_all = Question::count();
        $count_active = Question::active()->count();
        $count_inactive = Question::inactive()->count();
        $quizes = Quize::get();
        return view('dashboard.questions.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'quizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizes = Quize::get();
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
        $quizes = Quize::get();
        $item = Question::findOrFail($id);
        return view('dashboard.questions.edit', compact('item', 'quizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Question::findOrFail($id);
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
        Question::findOrFail($id)->delete();
        return redirect()->route('dashboard.questions.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
