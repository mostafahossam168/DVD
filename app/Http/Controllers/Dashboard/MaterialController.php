<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Lecture;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_materials|create_materials|update_materials|delete_materials', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_materials', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_materials', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_materials', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');

        $items = Material::when($search, function ($q) use ($search) {
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

        $count_all = Material::count();
        $count_active = Material::active()->count();
        $count_inactive = Material::inactive()->count();
        $lectuers = Lecture::get();
        return view('dashboard.materials.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'lectuers'));
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
            'lecture_id' => 'required|exists:lectures,id',
            'title' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10000',
            'status' => 'required|boolean',
        ]);

        $data['file'] = store_file($request->file, 'materials');
        Material::create($data);
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item =  Material::findOrFail($id);
        $data = $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'title' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10000',
            'status' => 'required|boolean',
        ]);
        if ($request->hasFile('file')) {
            delete_file($item->file);
            $data['file'] = store_file($request->file, 'materials');
        }
        $item->update($data);
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item =  Material::findOrFail($id);
        delete_file($item->file);
        $item->delete();
        return redirect()->route('dashboard.materials.index')->with('success', 'تم حفظ البيانات بنجاح');
    }
}
