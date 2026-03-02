<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Lecture;
use App\Models\Material;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_materials|create_materials|update_materials|delete_materials', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_materials', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_materials', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_materials', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $lecture_id = request('lecture_id');

        $query = Material::with(['lecture.subject.grade']);

        // إذا كان المستخدم مدرس (وليس admin)، يعرض فقط الملفات للدروس الخاصة بالمواد الخاصة به
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->whereHas('lecture.subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            });
        }

        $items = $query->when($search, function ($q) use ($search) {
            $q->whereAny(['title'], 'LIKE',  "%$search%");
        })
            ->when($lecture_id, function ($q) use ($lecture_id) {
                $q->where('lecture_id', $lecture_id);
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

        // جلب الدروس للمدرس فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lectuers = Lecture::whereHas('subject.teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->get();
        } else {
            $lectuers = Lecture::get();
        }

        $stages = Stage::active()->orderBy('name')->get();

        return view('dashboard.materials.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'lectuers', 'stages'));
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
            'lecture_id' => 'required|exists:lectures,id',
            'title' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10000',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المدرس يضيف ملف لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lecture = Lecture::with('subject')->findOrFail($data['lecture_id']);
            if (!$lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة ملف لهذا الدرس');
            }
        }

        $data['file'] = store_file($request->file, 'materials');
        Material::create($data);
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = Material::with(['lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يعدل ملف لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بتعديل هذا الملف');
            }
        }

        $data = $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'title' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10000',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المدرس يضيف ملف لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $lecture = Lecture::with('subject')->findOrFail($data['lecture_id']);
            if (!$lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة ملف لهذا الدرس');
            }
        }

        if ($request->hasFile('file')) {
            delete_file($item->file);
            $data['file'] = store_file($request->file, 'materials');
        }
        $item->update($data);
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Material::with(['lecture.subject'])->findOrFail($id);

        // التحقق من أن المدرس يحذف ملف لدرس لمادة خاصة به فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if (!$item->lecture->subject->teachers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'غير مصرح لك بحذف هذا الملف');
            }
        }

        delete_file($item->file);
        $item->delete();
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
