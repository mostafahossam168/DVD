<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreExpenseRequest;
use App\Models\Expense;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_subscriptions', ['only' => ['index']]);
        $this->middleware('permission:create_subscriptions', ['only' => ['store']]);
        $this->middleware('permission:delete_subscriptions', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $walletId = $request->input('payment_method_id');
        $category = $request->input('category');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $search = $request->string('search')->toString();

        $wallets = PaymentMethod::active()
            ->whereIn('code', ['vodafone_cash', 'instapay'])
            ->orderBy('name')
            ->get();

        $query = Expense::with(['paymentMethod', 'creator'])
            ->whereHas('paymentMethod', function ($q) {
                $q->whereIn('code', ['vodafone_cash', 'instapay']);
            })
            ->when($walletId, fn ($q) => $q->where('payment_method_id', $walletId))
            ->when($category, fn ($q) => $q->where('category', 'LIKE', "%{$category}%"))
            ->when($fromDate, fn ($q) => $q->whereDate('expense_date', '>=', $fromDate))
            ->when($toDate, fn ($q) => $q->whereDate('expense_date', '<=', $toDate))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('description', 'LIKE', "%{$search}%")
                        ->orWhere('category', 'LIKE', "%{$search}%");
                });
            });

        $items = (clone $query)->latest('expense_date')->latest()->paginate(20);
        $totalExpenses = (float) ((clone $query)->sum('amount') ?? 0);

        $walletCards = $wallets->map(function ($wallet) use ($query) {
            return [
                'id' => $wallet->id,
                'name' => $wallet->name,
                'account_number' => $wallet->account_number,
                'total' => (float) ((clone $query)->where('payment_method_id', $wallet->id)->sum('amount') ?? 0),
            ];
        });

        return view('dashboard.expenses.index', compact('items', 'wallets', 'walletCards', 'totalExpenses'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        Expense::create($data);

        return redirect()->route('dashboard.expenses.index')->with('success', 'تم تسجيل المصروف بنجاح.');
    }

    public function destroy(Expense $expense)
    {
        if (!in_array($expense->paymentMethod?->code, ['vodafone_cash', 'instapay'], true)) {
            return redirect()->route('dashboard.expenses.index')->with('error', 'لا يمكن حذف هذا المصروف.');
        }

        $expense->delete();
        return redirect()->route('dashboard.expenses.index')->with('success', 'تم حذف المصروف بنجاح.');
    }
}

