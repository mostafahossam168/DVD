<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreParentRequest;
use App\Http\Requests\Dashboard\UpdateParentRequest;
use App\Models\User;
use Illuminate\Routing\Controller;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_parents|create_parents|update_parents|delete_parents', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_parents', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_parents', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_parents', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $items = User::when($search, function ($q) use ($search) {
            $q->whereAny(['f_name', 'l_name', 'email', 'phone'], 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->parents()->with('children')->latest()->paginate(20);

        $count_all = User::parents()->count();
        $count_active = User::parents()->active()->count();
        $count_inactive = User::parents()->inactive()->count();
        return view('dashboard.parents.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::students()->orderBy('f_name')->get();
        return view('dashboard.parents.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParentRequest $request)
    {
        $data = $request->validated();
        $children = $data['children'] ?? [];
        unset($data['children']);
        $data['type'] = 'parent';
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'parents');
        }
        $parent = User::create($data);
        $parent->children()->sync($children);
        return redirect()->route('dashboard.parents.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = User::findOrFail($id);
        $students = User::students()->orderBy('f_name')->get();
        $selectedChildren = $item->children()->pluck('users.id')->all();
        return view('dashboard.parents.edit', compact('item', 'students', 'selectedChildren'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParentRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $children = $data['children'] ?? [];
        unset($data['children']);
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'parents');
            delete_file($user->image);
        }
        $user->update($data);
        $user->children()->sync($children);
        return redirect()->route('dashboard.parents.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = User::findOrFail($id);
        if ($item->image) {
            delete_file($item->image);
        }
        $item->delete();
        return redirect()->route('dashboard.parents.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
