<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_coupons|create_coupons|update_coupons|delete_coupons', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_coupons', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_coupons', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_coupons', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $type = request('type');

        $items = Coupon::when($search, function ($q) use ($search) {
            $q->whereAny(['code', 'name', 'description'], 'LIKE', "%$search%");
        })
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })
            ->latest()
            ->paginate(20);

        $count_all = Coupon::count();
        $count_active = Coupon::active()->count();
        $count_inactive = Coupon::inactive()->count();

        return view('dashboard.coupons.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        // التحقق من قيمة الخصم حسب النوع
        if ($data['type'] === 'percentage' && $data['value'] > 100) {
            return redirect()->back()->with('error', 'قيمة الخصم بالنسبة المئوية لا يمكن أن تتجاوز 100%');
        }

        $data['used_count'] = 0;
        Coupon::create($data);
        return redirect()->route('dashboard.coupons.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = Coupon::findOrFail($id);
        return view('dashboard.coupons.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $data = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $id . '|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        // التحقق من قيمة الخصم حسب النوع
        if ($data['type'] === 'percentage' && $data['value'] > 100) {
            return redirect()->back()->with('error', 'قيمة الخصم بالنسبة المئوية لا يمكن أن تتجاوز 100%');
        }

        // التحقق من أن حد الاستخدام لا يقل عن عدد مرات الاستخدام الحالي
        if ($data['usage_limit'] && $data['usage_limit'] < $coupon->used_count) {
            return redirect()->back()->with('error', 'حد الاستخدام لا يمكن أن يكون أقل من عدد مرات الاستخدام الحالي');
        }

        $coupon->update($data);
        return redirect()->route('dashboard.coupons.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Coupon::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard.coupons.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
