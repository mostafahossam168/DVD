<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreLectuerRequest;
use App\Http\Requests\Dashboard\UpdateLectuerRequest;
use App\Models\Stage;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\User;
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

        $subjects = Subject::active()->get();

        return view('dashboard.lectuers.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::get();
        $subjects = Subject::active()->get();

        return view('dashboard.lectuers.create', compact('stages', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectuerRequest $request)
    {
        $data = $request->validated();

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
        $subjects = Subject::active()->get();

        return view('dashboard.lectuers.edit', compact('item', 'stages', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectuerRequest $request, string $id)
    {
        $item = Lecture::with('subject')->findOrFail($id);

        $data = $request->validated();

        $item->update($data);
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * عرض حالة مشاهدة الطلاب لهذه المحاضرة.
     */
    public function progress(string $id)
    {
        $lecture = Lecture::with('subject')->findOrFail($id);

        $students = User::students()->active()
            ->whereHas('courseSubscriptions', function ($q) use ($lecture) {
                $q->active()->where('subject_id', $lecture->subject_id);
            })
            ->with(['lectureProgress' => function ($q) use ($lecture) {
                $q->where('lecture_id', $lecture->id);
            }])
            ->orderBy('f_name')
            ->get();

        return view('dashboard.lectuers.progress', compact('lecture', 'students'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Lecture::with('subject')->findOrFail($id);

        $item->delete();
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
