<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Stage;
use App\Models\Lecture;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LectuerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_lectuers|create_lectuers|update_lectuers|delete_lectuers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_lectuers', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_lectuers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_lectuers', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $subject_id = request('subject_id');

        $query = Lecture::with('subject');

        // إذا كان المستخدم مدرس (وليس admin)، يعرض فقط الدروس للمواد الخاصة به
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->whereHas('subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            });
        }

        $items = $query->when($search, function ($q) use ($search) {
            $q->whereAny(['title', 'description'], 'LIKE',  "%$search%");
        })
            ->when($subject_id, function ($q) use ($subject_id) {
                $q->where('subject_id', $subject_id);
            })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(20);

        $count_all = $query->count();
        $count_active = (clone $query)->active()->count();
        $count_inactive = (clone $query)->inactive()->count();

        // جلب المواد للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subjects = Subject::whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->active()->get();
        } else {
            $subjects = Subject::active()->get();
        }

        return view('dashboard.lectuers.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::get();

        // جلب المواد للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subjects = Subject::whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->active()->get();
        } else {
            $subjects = Subject::active()->get();
        }

        return view('dashboard.lectuers.create', compact('stages', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string|min:5',
            'link' => 'required|url',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المدرس يضيف درس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subject = Subject::findOrFail($data['subject_id']);
            if (!$subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة درس لهذه المادة');
            }
        }

        Lecture::create($data);
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $stages = Stage::get();
        $item = Lecture::with('subject')->findOrFail($id);

        // التحقق من أن المدرس يعدل درس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا الدرس');
            }
        }

        // جلب المواد للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subjects = Subject::whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->active()->get();
        } else {
            $subjects = Subject::active()->get();
        }

        return view('dashboard.lectuers.edit', compact('item', 'stages', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Lecture::with('subject')->findOrFail($id);

        // التحقق من أن المدرس يعدل درس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا الدرس');
            }
        }

        $data = $request->validate([
            'title' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string|min:5',
            'link' => 'required|url',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المدرس يضيف درس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subject = Subject::findOrFail($data['subject_id']);
            if (!$subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة درس لهذه المادة');
            }
        }

        $item->update($data);
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Lecture::with('subject')->findOrFail($id);

        // التحقق من أن المدرس يحذف درس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بحذف هذا الدرس');
            }
        }

        $item->delete();
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
