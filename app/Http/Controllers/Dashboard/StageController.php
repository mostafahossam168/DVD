<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Stage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');

        $items = Stage::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE',  "%$search%");
        })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(20);

        $count_all = Stage::count();
        $count_active = Stage::active()->count();
        $count_inactive = Stage::inactive()->count();
        return view('dashboard.stages.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
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
            'name' => 'required|string|unique:stages,name',
            'status' => 'required|boolean',
        ]);
        Stage::create($data);
        return redirect()->route('dashboard.stages.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $stage = Stage::findOrFail($id);
        $data =  $request->validate([
            'name' => 'required|string|unique:stages,name,' . $stage->id,
            'status' => 'required|boolean',
        ]);
        $stage->update($data);
        return redirect()->route('dashboard.stages.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();
        return redirect()->route('dashboard.stages.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
