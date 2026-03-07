<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Grade;
use App\Models\Stage;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_subjects|create_subjects|update_subjects|delete_subjects', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_subjects', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_subjects', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_subjects', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $grade_id = request('grade_id');
        $stage_id = request('stage_id');

        $query = Subject::query();

        // إذا كان المستخدم مدرس (وليس admin)، يعرض فقط المواد الخاصة به
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            });
        }

        $items = $query->when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE',  "%$search%");
        })
            ->when($stage_id, function ($q) use ($stage_id) {
                $q->whereHas('grade', function ($query) use ($stage_id) {
                    $query->where('stage_id', $stage_id);
                });
            })
            ->when($grade_id, function ($q) use ($grade_id) {
                $q->where('grade_id', $grade_id);
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
        $grades = Grade::all();
        $stages = Stage::active()->get();
        $teachers = User::teachers()->get();
        return view('dashboard.subjects.index', compact('items', 'count_all', 'teachers', 'count_active', 'count_inactive', 'grades', 'stages'));
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
        $request->merge(['price' => $request->input('price') ?: null]);
        $data =  $request->validate([
            'name' => 'required|string',
            'status' => 'required|boolean',
            'image' => 'required|image',
            'grade_id' => 'required|exists:grades,id',
            'teacher_id' => 'nullable|array|exists:users,id',
            'price' => 'nullable|numeric|min:0',
        ]);
        $data['image'] = store_file($request->image, 'subjects');
        $subject = Subject::create($data);
        if (!empty($request->teacher_id)) {
            $subject->teachers()->attach($data['teacher_id']);
        }
        return redirect()->route('dashboard.subjects.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item =  Subject::findOrFail($id);
        $request->merge(['price' => $request->input('price') ?: null]);
        $data =  $request->validate([
            'name' => 'required|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image',
            'grade_id' => 'required|exists:grades,id',
            'price' => 'nullable|numeric|min:0',
        ]);
        if ($request->hasFile('image')) {
            delete_file($item->image);
            $data['image'] = store_file($request->image, 'subjects');
        }
        $item->update($data);
        return redirect()->route('dashboard.subjects.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item =  Subject::findOrFail($id);
        delete_file($item->image);
        $item->delete();
        return redirect()->route('dashboard.subjects.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
