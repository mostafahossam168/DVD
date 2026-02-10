<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $grade_id = request('grade_id');
        $items = Subject::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE',  "%$search%");
        })->when($grade_id, function ($q) use ($grade_id) {
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

        $count_all = Subject::count();
        $count_active = Subject::active()->count();
        $count_inactive = Subject::inactive()->count();
        $grades = Grade::all();
        $teachers = User::teachers()->get();
        return view('dashboard.subjects.index', compact('items', 'count_all', 'teachers', 'count_active', 'count_inactive', 'grades'));
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
        $data =  $request->validate([
            'name' => 'required|string|unique:subjects,name',
            'status' => 'required|boolean',
            'image' => 'required|mimes:jpg,png,jpeg',
            'grade_id' => 'required|exists:grades,id',
            'teacher_id' => 'nullable|array|exists:users,id',
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
        $data =  $request->validate([
            'name' => 'required|string|unique:subjects,name,' . $id,
            'status' => 'required|boolean',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'grade_id' => 'required|exists:grades,id'
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
