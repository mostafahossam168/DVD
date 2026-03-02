<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


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

        $baseQuery = Subscription::with(['user', 'subject']);

        // المدرس يرى فقط اشتراكات الطلاب في مواده
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', auth()->id()))->pluck('id');
            $baseQuery->whereIn('subject_id', $teacherSubjectIds);
        }

        $items = $baseQuery
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

        $countQuery = Subscription::query();
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $teacherSubjectIds = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', auth()->id()))->pluck('id');
            $countQuery->whereIn('subject_id', $teacherSubjectIds);
        }
        $count_all = $countQuery->count();
        $count_active = (clone $countQuery)->active()->count();
        $count_inactive = (clone $countQuery)->inactive()->count();

        $students = User::students()->active()->get();
        $subjects = auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')
            ? Subject::whereHas('teachers', fn ($q) => $q->where('users.id', auth()->id()))->active()->get()
            : Subject::active()->get();

        return view('dashboard.subscriptions.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'students', 'subjects'));
    }

    /**
     * طلبات الاشتراك المعلقة (بانتظار الموافقة على الدفع).
     */
    public function pending()
    {
        $items = Subscription::with(['user', 'subject'])
            ->where('payment_status', 'pending')
            ->latest()
            ->paginate(20);
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
