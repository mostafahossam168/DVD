<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Quize;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuizeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_quizes|create_quizes|update_quizes|delete_quizes', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_quizes', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_quizes', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_quizes', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $lecture_id = request('lecture_id');

        $query = Quize::with(['lecture.subject']);

        // إذا كان المستخدم مدرس (وليس admin)، يعرض فقط الاختبارات للدروس الخاصة بالمواد الخاصة به
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->whereHas('lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            });
        }

        $items = $query->when($search, function ($q) use ($search) {
            $q->where('title', 'LIKE', "%$search%");
        })->when($lecture_id, function ($q) use ($lecture_id) {
            $q->where('lecture_id', $lecture_id);
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

        // جلب الدروس للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lectuers = Lecture::whereHas('subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->get();
        } else {
            $lectuers = Lecture::get();
        }

        return view('dashboard.quizes.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'lectuers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'lecture_id' => 'required|exists:lectures,id',
            'status' => 'required|boolean',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // التحقق من أن المدرس يضيف اختبار لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lecture = Lecture::with('subject')->findOrFail($data['lecture_id']);
            if (!$lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة اختبار لهذا الدرس');
            }
        }

        Quize::create($data);
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Quize::with(['lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يعدل اختبار لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا الاختبار');
            }
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'lecture_id' => 'required|exists:lectures,id',
            'status' => 'required|boolean',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // التحقق من أن المدرس يضيف اختبار لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lecture = Lecture::with('subject')->findOrFail($data['lecture_id']);
            if (!$lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة اختبار لهذا الدرس');
            }
        }

        $item->update($data);
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Quize::with(['lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يحذف اختبار لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بحذف هذا الاختبار');
            }
        }

        $item->delete();
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
