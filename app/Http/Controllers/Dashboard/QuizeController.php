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
        $items = Quize::when($search, function ($q) use ($search) {
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

        $count_all = Quize::count();
        $count_active = Quize::active()->count();
        $count_inactive = Quize::inactive()->count();
        $lectuers = Lecture::get();
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
        $item = Quize::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|max:255',
            'lecture_id' => 'required|exists:lectures,id',
            'status' => 'required|boolean',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);
        $item->update($data);
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Quize::findOrFail($id)->delete();
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}