<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_plans|create_plans|update_plans|delete_plans', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_plans', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_plans', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_plans', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');

        $items = Plan::when($search, function ($q) use ($search) {
            $q->whereAny(['name', 'price'], 'LIKE',  "%$search%");
        })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })->latest()->paginate(20);

        $count_all = Plan::count();
        $count_active = Plan::active()->count();
        $count_inactive = Plan::inactive()->count();
        return view('dashboard.plans.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
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
            'name' => 'required|string|unique:plans,name',
            'price' => 'required|numeric',
            'subjects_limit' => 'required|min:1|integer',
            'students_limit' => 'required|min:1|integer',
            'status' => 'required|boolean',
        ]);
        Plan::create($data);
        return redirect()->route('dashboard.plans.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $plan = Plan::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|unique:plans,name,' . $id,
            'price' => 'required|numeric',
            'subjects_limit' => 'required|min:1|integer',
            'students_limit' => 'required|min:1|integer',
            'status' => 'required|boolean',
        ]);
        $plan->update($data);
        return redirect()->route('dashboard.plans.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('dashboard.plans.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
