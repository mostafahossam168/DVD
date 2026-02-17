<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $stage_id = request('stage_id');
        $items = Grade::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE',  "%$search%");
        })->when($stage_id, function ($q) use ($stage_id) {
            $q->where('stage_id', $stage_id);
        })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(20);

        $count_all = Grade::count();
        $count_active = Grade::active()->count();
        $count_inactive = Grade::inactive()->count();
        $stages = Stage::active()->get();
        return view('dashboard.grades.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'stages'));
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
            'name' => 'required|string|unique:grades,name',
            'status' => 'required|boolean',
            'stage_id' => 'required|exists:stages,id'
        ]);
        Grade::create($data);
        return redirect()->route('dashboard.grades.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $grade = Grade::findOrFail($id);
        $data =  $request->validate([
            'name' => 'required|string|unique:grades,name,' . $grade->id,
            'status' => 'required|boolean',
            'stage_id' => 'required|exists:stages,id'
        ]);
        $grade->update($data);
        return redirect()->route('dashboard.grades.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();
        return redirect()->route('dashboard.grades.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
