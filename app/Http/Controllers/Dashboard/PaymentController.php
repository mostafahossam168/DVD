<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_subscriptions', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $method = $request->input('method');
        $status = $request->input('payment_status');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $search = $request->string('search')->toString();

        $allowedMethods = ['vodafone_cash', 'instapay'];

        $query = Subscription::with(['user', 'subject.teacher'])
            ->whereIn('payment_method', $allowedMethods);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
            $query->whereIn('subject_id', $teacherSubjectIds);
        }

        $query
            ->when($method, fn ($q) => $q->where('payment_method', $method))
            ->when($status, fn ($q) => $q->where('payment_status', $status))
            ->when($fromDate, fn ($q) => $q->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn ($q) => $q->whereDate('created_at', '<=', $toDate))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->whereHas('user', function ($uq) use ($search) {
                        $uq->whereAny(['f_name', 'l_name', 'email', 'phone'], 'LIKE', "%{$search}%");
                    })->orWhereHas('subject', function ($sq) use ($search) {
                        $sq->where('name', 'LIKE', "%{$search}%");
                    })->orWhere('payment_phone', 'LIKE', "%{$search}%")
                        ->orWhere('payment_reference', 'LIKE', "%{$search}%");
                });
            });

        $payments = (clone $query)->latest()->paginate(20);

        $summaryQuery = clone $query;
        $paidAmount = (float) ((clone $summaryQuery)->where('payment_status', 'paid')->sum('amount_paid') ?? 0);
        $pendingAmount = (float) ((clone $summaryQuery)->where('payment_status', 'pending')->sum('amount_paid') ?? 0);

        $methodNames = [
            'vodafone_cash' => 'فودافون كاش',
            'instapay' => 'انستاباي',
        ];

        $split = function (?string $value) {
            return collect(preg_split('/[\r\n,]+/', (string) $value))
                ->map(fn ($x) => trim($x))
                ->filter()
                ->values();
        };

        $walletCards = collect($allowedMethods)->map(function ($code) use ($query, $methodNames, $split) {
            $numbers = $code === 'vodafone_cash'
                ? $split(setting('vodafone_cash_numbers'))
                : $split(setting('instapay_numbers'));

            $methodPaid = (float) ((clone $query)->where('payment_method', $code)->where('payment_status', 'paid')->sum('amount_paid') ?? 0);

            return [
                'code' => $code,
                'name' => $methodNames[$code] ?? $code,
                'numbers' => $numbers,
                'paid_amount' => $methodPaid,
            ];
        });

        return view('dashboard.payments.index', compact('payments', 'walletCards', 'paidAmount', 'pendingAmount'));
    }
}

