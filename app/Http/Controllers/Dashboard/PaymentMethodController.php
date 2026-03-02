<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_payment_methods', ['only' => ['index']]);
        $this->middleware('permission:create_payment_methods', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_payment_methods', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $items = PaymentMethod::orderBy('name')->paginate(20);
        $count_active = PaymentMethod::active()->count();
        $count_inactive = PaymentMethod::where('is_active', false)->count();
        return view('dashboard.payment-methods.index', compact('items', 'count_active', 'count_inactive'));
    }

    public function create()
    {
        return view('dashboard.payment-methods.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'is_active' => 'required|boolean',
        ]);
        PaymentMethod::create($data);
        return redirect()->route('dashboard.payment-methods.index')->with('success', 'تم حفظ طريقة الدفع بنجاح');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('dashboard.payment-methods.edit', ['item' => $paymentMethod]);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'is_active' => 'required|boolean',
        ]);
        $paymentMethod->update($data);
        return redirect()->route('dashboard.payment-methods.index')->with('success', 'تم تحديث طريقة الدفع بنجاح');
    }
}
