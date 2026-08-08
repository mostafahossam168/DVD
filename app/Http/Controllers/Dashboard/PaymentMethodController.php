<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StorePaymentMethodRequest;
use App\Http\Requests\Dashboard\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
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

    public function store(StorePaymentMethodRequest $request)
    {
        $data = $request->validated();
        PaymentMethod::create($data);
        return redirect()->route('dashboard.payment-methods.index')->with('success', 'تم حفظ طريقة الدفع بنجاح');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('dashboard.payment-methods.edit', ['item' => $paymentMethod]);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $data = $request->validated();
        $paymentMethod->update($data);
        return redirect()->route('dashboard.payment-methods.index')->with('success', 'تم تحديث طريقة الدفع بنجاح');
    }
}
