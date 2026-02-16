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

        $items = Lecture::when($search, function ($q) use ($search) {
            $q->whereAny(['title', 'description'], 'LIKE',  "%$search%");
        })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(20);

        $count_all = Lecture::count();
        $count_active = Lecture::active()->count();
        $count_inactive = Lecture::inactive()->count();
        return view('dashboard.lectuers.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::get();
        return view('dashboard.lectuers.create', compact('stages'));
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
        $item = Lecture::findOrFail($id);
        return view('dashboard.lectuers.edit', compact('item', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Lecture::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string|min:5',
            'link' => 'required|url',
            'status' => 'required|boolean',
        ]);
        $item->update($data);
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Lecture::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard.lectuers.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
