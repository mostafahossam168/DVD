<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreQuizeRequest;
use App\Http\Requests\Dashboard\UpdateQuizeRequest;
use App\Models\Quize;
use App\Models\Lecture;
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

        $query = Quize::with(['lecture.subject', 'questions']);

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
    public function store(StoreQuizeRequest $request)
    {
        $data = $request->validated();

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
    public function update(UpdateQuizeRequest $request, string $id)
    {
        $item = Quize::with(['lecture.subject'])->findOrFail($id);

        $data = $request->validated();

        $item->update($data);
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Quize::with(['lecture.subject'])->findOrFail($id);

        $item->delete();
        return redirect()->route('dashboard.quizes.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
