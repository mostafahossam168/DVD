<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_admins|create_admins|update_admins|delete_admins', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_admins', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_admins', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
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
        })->admins()->latest()->paginate(20);
        $count_all = User::admins()->count();
        $count_active = User::admins()->active()->count();
        $count_inactive = User::admins()->inactive()->count();
        return view('dashboard.admins.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = DB::table('roles')->select('name')->get();
        return view('dashboard.admins.create', compact('roles'));
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
            'role' => 'required|required|exists:roles,name',
            'password' => ['required', 'min:3', 'confirmed', 'string'],
        ]);
        $data['passsword'] = bcrypt($request->password);
        $data['type'] = 'admin';
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'admins');
        }
        $user = User::create($data);
        $user->assignRole($data['role']);
        return redirect()->route('dashboard.admins.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $roles = DB::table('roles')->select('name')->get();
        return view('dashboard.admins.edit', compact('item', 'roles'));
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
            'role' => 'required|required|exists:roles,name',
            'password' => ['nullable', 'min:3', 'confirmed', 'string'],
        ]);
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'admins');
            delete_file($user->image);
        }
        $user->update($data);
        $user->syncRoles($data['role']);
        return redirect()->route('dashboard.admins.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item =  User::find($id);
        $item->delete();
        return redirect()->route('dashboard.admins.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
