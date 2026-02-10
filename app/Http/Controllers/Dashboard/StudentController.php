<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_students|create_students|update_students|delete_students', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_students', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_students', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_students', ['only' => ['destroy']]);
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
        })->students()->latest()->paginate(20);

        $count_all = User::students()->count();
        $count_active = User::students()->active()->count();
        $count_inactive = User::students()->inactive()->count();
        return view('dashboard.students.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'f_name' => 'required|string|min:3|max:255',
            'l_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'image' => 'nullable|mimes:jpg,png',
            'status' => 'required|boolean',
            'password' => ['required', 'min:3', 'confirmed', 'string'],
        ]);
        $data['passsword'] = bcrypt($request->password);
        $data['type'] = 'student';
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'students');
        }
        User::create($data);
        return redirect()->route('dashboard.students.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = User::find($id);
        return view('dashboard.students.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'f_name' => 'required|string|min:3|max:255',
            'l_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'image' => 'nullable|mimes:jpg,png',
            'status' => 'required|boolean',
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ]);
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'students');
            delete_file($user->image);
        }
        $user->update($data);
        return redirect()->route('dashboard.students.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item =  User::findOrFail($id);
        if ($item->image) {
            delete_file($item->image);
        }
        $item->delete();
        return redirect()->route('dashboard.students.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
