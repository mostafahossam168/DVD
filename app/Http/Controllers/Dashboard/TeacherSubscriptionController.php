<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\TeacherSubscription;


class TeacherSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_teacher_subscriptions|create_teacher_subscriptions|update_teacher_subscriptions|delete_teacher_subscriptions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_teacher_subscriptions', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_teacher_subscriptions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_teacher_subscriptions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $teacher_id = request('teacher_id');
        $plan_id = request('plan_id');

        $query = TeacherSubscription::with(['user', 'plan']);

        // إذا كان المستخدم مدرس (وليس admin)، يعرض اشتراكه فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        $items = $query
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->whereAny(['f_name', 'l_name', 'email', 'phone'], 'LIKE', "%$search%");
                })->orWhereHas('plan', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                });
            })
            ->when($teacher_id, function ($q) use ($teacher_id) {
                $q->where('user_id', $teacher_id);
            })
            ->when($plan_id, function ($q) use ($plan_id) {
                $q->where('plan_id', $plan_id);
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

        $count_all = TeacherSubscription::count();
        $count_active = TeacherSubscription::active()->count();
        $count_inactive = TeacherSubscription::inactive()->count();
        $teachers = User::teachers()->active()->get();
        $plans = Plan::active()->get();

        return view('dashboard.teacher-subscriptions.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'teachers', 'plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::teachers()->active()->get();
        $plans = Plan::active()->get();
        return view('dashboard.teacher-subscriptions.create', compact('teachers', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المستخدم مدرس
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'teacher') {
            return redirect()->back()->with('error', 'يجب اختيار مدرس صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر للمدرس
        $existing = TeacherSubscription::where('user_id', $data['user_id'])->first();

        if ($existing) {
            return redirect()->back()->with('error', 'المدرس لديه اشتراك بالفعل');
        }

        TeacherSubscription::create($data);
        return redirect()->route('dashboard.teacher-subscriptions.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = TeacherSubscription::with(['user', 'plan'])->findOrFail($id);

        // إذا كان المستخدم مدرس (وليس admin)، يمكنه تعديل اشتراكه فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if ($item->user_id !== auth()->id()) {
                abort(403, 'غير مصرح لك بتعديل هذا الاشتراك');
            }
        }

        $teachers = User::teachers()->active()->get();
        $plans = Plan::active()->get();
        return view('dashboard.teacher-subscriptions.edit', compact('item', 'teachers', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subscription = TeacherSubscription::findOrFail($id);

        // إذا كان المستخدم مدرس (وليس admin)، يمكنه تعديل اشتراكه فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if ($subscription->user_id !== auth()->id()) {
                abort(403, 'غير مصرح لك بتعديل هذا الاشتراك');
            }
        }

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|boolean',
        ]);

        // التحقق من أن المستخدم مدرس
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'teacher') {
            return redirect()->back()->with('error', 'يجب اختيار مدرس صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر (عدا الاشتراك الحالي)
        $existing = TeacherSubscription::where('user_id', $data['user_id'])
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'المدرس لديه اشتراك آخر بالفعل');
        }

        $subscription->update($data);
        return redirect()->route('dashboard.teacher-subscriptions.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = TeacherSubscription::findOrFail($id);

        // إذا كان المستخدم مدرس (وليس admin)، يمكنه حذف اشتراكه فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            if ($item->user_id !== auth()->id()) {
                abort(403, 'غير مصرح لك بحذف هذا الاشتراك');
            }
        }

        $item->delete();
        return redirect()->route('dashboard.teacher-subscriptions.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
