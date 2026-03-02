<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_teachers|create_teachers|update_teachers|delete_teachers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_teachers', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_teachers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_teachers', ['only' => ['destroy']]);
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
        })->teachers()->latest()->paginate(20);

        $count_all = User::teachers()->count();
        $count_active = User::teachers()->active()->count();
        $count_inactive = User::teachers()->inactive()->count();
        return view('dashboard.teachers.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = DB::table('roles')->select('name')->get();
        return view('dashboard.teachers.create', compact('roles'));
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
            'more_information' => 'nullable|string',
            'status' => 'required|boolean',
            'role' => ['nullable', 'exists:roles,name'],
            'password' => ['required', 'min:3', 'confirmed', 'string'],
        ]);
        $data['passsword'] = bcrypt($request->password);
        $data['type'] = 'teacher';
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'teachers');
        }
        $user = User::create($data);
        if ($request->role) {
            $user->assignRole($data['role']);
        } elseif (\Spatie\Permission\Models\Role::where('name', 'teacher')->exists()) {
            $user->assignRole('teacher');
        }
        return redirect()->route('dashboard.teachers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = User::find($id);
        $roles = DB::table('roles')->select('name')->get();
        return view('dashboard.teachers.show', compact('item', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::find($id);
        $roles = DB::table('roles')->select('name')->get();
        return view('dashboard.teachers.edit', compact('item', 'roles'));
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
            'more_information' => 'nullable|string',
            'status' => 'required|boolean',
            'role' => ['nullable', 'exists:roles,name'],
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ]);
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'teachers');
            delete_file($user->image);
        }
        $user->update($data);
        if ($request->role) {
            $user->assignRole($data['role']);
        }
        return redirect()->route('dashboard.teachers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item =  User::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard.teachers.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
