<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_subscriptions|create_subscriptions|update_subscriptions|delete_subscriptions', ['only' => ['index', 'store', 'pending', 'approve', 'reject']]);
        $this->middleware('permission:create_subscriptions', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_subscriptions', ['only' => ['edit', 'update', 'approve', 'reject']]);
        $this->middleware('permission:delete_subscriptions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $student_id = request('student_id');
        $subject_id = request('subject_id');
        $payment_status = request('payment_status');
        $payment_method = request('payment_method');
        $from_date = request('from_date');
        $to_date = request('to_date');

        $baseQuery = Subscription::with(['user', 'subject.teacher']);

        // المدرس يرى فقط اشتراكات الطلاب في مواده
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
            $baseQuery->whereIn('subject_id', $teacherSubjectIds);
        }

        $filteredQuery = $baseQuery
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->whereAny(['f_name', 'l_name', 'email', 'phone'], 'LIKE', "%$search%");
                })->orWhereHas('subject', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                });
            })
            ->when($student_id, function ($q) use ($student_id) {
                $q->where('user_id', $student_id);
            })
            ->when($subject_id, function ($q) use ($subject_id) {
                $q->where('subject_id', $subject_id);
            })
            ->when($payment_status, function ($q) use ($payment_status) {
                $q->where('payment_status', $payment_status);
            })
            ->when($payment_method, function ($q) use ($payment_method) {
                $q->where('payment_method', $payment_method);
            })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->active();
                }
                if ($status == 'no') {
                    $q->inactive();
                }
            })
            ->when($from_date, function ($q) use ($from_date) {
                $q->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($q) use ($to_date) {
                $q->whereDate('created_at', '<=', $to_date);
            });

        $items = (clone $filteredQuery)
            ->latest()
            ->paginate(20);

        $countQuery = Subscription::query();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
            $countQuery->whereIn('subject_id', $teacherSubjectIds);
        }
        $count_all = $countQuery->count();
        $count_active = (clone $countQuery)->active()->count();
        $count_inactive = (clone $countQuery)->inactive()->count();

        $paidCount = (clone $filteredQuery)->where('payment_status', 'paid')->count();
        $pendingCount = (clone $filteredQuery)->where('payment_status', 'pending')->count();
        $rejectedCount = (clone $filteredQuery)->where('payment_status', 'rejected')->count();

        // إجماليات مالية دقيقة حتى لو amount_paid فارغ في سجلات قديمة
        $paidAmount = (float) ((clone $filteredQuery)
            ->leftJoin('subjects', 'subjects.id', '=', 'subscriptions.subject_id')
            ->where('subscriptions.payment_status', 'paid')
            ->selectRaw('SUM(COALESCE(subscriptions.amount_paid, subjects.price, 0)) as total_amount')
            ->value('total_amount') ?? 0);

        $allAmount = (float) ((clone $filteredQuery)
            ->leftJoin('subjects', 'subjects.id', '=', 'subscriptions.subject_id')
            ->selectRaw('SUM(COALESCE(subscriptions.amount_paid, subjects.price, 0)) as total_amount')
            ->value('total_amount') ?? 0);

        $students = User::students()->active()->get();
        $subjects = Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')
            ? Subject::where('teacher_id', Auth::id())->active()->get()
            : Subject::active()->get();
        $paymentMethods = Subscription::query()
            ->select('payment_method')
            ->whereNotNull('payment_method')
            ->where('payment_method', '!=', '')
            ->distinct()
            ->orderBy('payment_method')
            ->pluck('payment_method');

        return view('dashboard.subscriptions.index', compact(
            'items',
            'count_all',
            'count_active',
            'count_inactive',
            'students',
            'subjects',
            'paymentMethods',
            'paidCount',
            'pendingCount',
            'rejectedCount',
            'paidAmount',
            'allAmount'
        ));
    }

    /**
     * طلبات الاشتراك المعلقة (بانتظار الموافقة على الدفع).
     */
    public function pending()
    {
        $query = Subscription::with(['user', 'subject.teacher'])
            ->where('payment_status', 'pending');

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
            $query->whereIn('subject_id', $teacherSubjectIds);
        }

        $items = $query->latest()->paginate(20);
        return view('dashboard.subscriptions.pending', compact('items'));
    }

    /**
     * الموافقة على طلب اشتراك وتفعيله.
     */
    public function approve(Subscription $subscription)
    {
        if ($subscription->payment_status !== 'pending') {
            return redirect()->route('dashboard.subscriptions-pending')->with('error', 'هذا الطلب غير معلق.');
        }
        $subscription->update([
            'status' => true,
            'payment_status' => 'paid',
            'amount_paid' => $subscription->amount_paid ?: ($subscription->subject?->price ?? 0),
        ]);
        return redirect()->route('dashboard.subscriptions-pending')->with('success', 'تمت الموافقة على الاشتراك وتفعيله.');
    }

    /**
     * رفض طلب اشتراك.
     */
    public function reject(Subscription $subscription)
    {
        if ($subscription->payment_status !== 'pending') {
            return redirect()->route('dashboard.subscriptions-pending')->with('error', 'هذا الطلب غير معلق.');
        }
        $subscription->update(['payment_status' => 'rejected']);
        return redirect()->route('dashboard.subscriptions-pending')->with('success', 'تم رفض طلب الاشتراك.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::students()->active()->get();
        $subjects = Subject::active()->get();
        return view('dashboard.subscriptions.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'required|boolean',
            'period_type' => 'required|in:term,month',
            'term_number' => 'required_if:period_type,term|nullable|integer|min:1|max:3',
            'start_date' => 'required_if:period_type,month|nullable|date',
            'end_date' => 'required_if:period_type,month|nullable|date|after_or_equal:start_date',
        ]);

        // التحقق من أن المستخدم طالب
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'student') {
            return redirect()->back()->with('error', 'يجب اختيار طالب صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر لنفس الفترة
        $existingQuery = Subscription::where('user_id', $data['user_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('period_type', $data['period_type']);

        if ($data['period_type'] === 'term') {
            $existingQuery->where('term_number', $data['term_number']);
        } else {
            $existingQuery
                ->whereDate('start_date', $data['start_date'])
                ->whereDate('end_date', $data['end_date']);
        }

        $existing = $existingQuery->first();

        if ($existing) {
            return redirect()->back()->with('error', 'الطالب مشترك بالفعل في هذا المادة');
        }

        $data['amount_paid'] = Subject::find($data['subject_id'])?->price ?? 0;
        Subscription::create($data);
        return redirect()->route('dashboard.subscriptions.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = Subscription::with(['user', 'subject'])->findOrFail($id);
        $students = User::students()->active()->get();
        $subjects = Subject::active()->get();
        return view('dashboard.subscriptions.edit', compact('item', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'required|boolean',
            'period_type' => 'required|in:term,month',
            'term_number' => 'required_if:period_type,term|nullable|integer|min:1|max:3',
            'start_date' => 'required_if:period_type,month|nullable|date',
            'end_date' => 'required_if:period_type,month|nullable|date|after_or_equal:start_date',
        ]);

        // التحقق من أن المستخدم طالب
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'student') {
            return redirect()->back()->with('error', 'يجب اختيار طالب صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر لنفس الفترة (عدا الاشتراك الحالي)
        $existingQuery = Subscription::where('user_id', $data['user_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('period_type', $data['period_type'])
            ->where('id', '!=', $id);

        if ($data['period_type'] === 'term') {
            $existingQuery->where('term_number', $data['term_number']);
        } else {
            $existingQuery
                ->whereDate('start_date', $data['start_date'])
                ->whereDate('end_date', $data['end_date']);
        }

        $existing = $existingQuery->first();

        if ($existing) {
            return redirect()->back()->with('error', 'الطالب مشترك بالفعل في هذا المادة');
        }

        $data['amount_paid'] = Subject::find($data['subject_id'])?->price ?? ($subscription->amount_paid ?? 0);

        $subscription->update($data);
        return redirect()->route('dashboard.subscriptions.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Subscription::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard.subscriptions.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
