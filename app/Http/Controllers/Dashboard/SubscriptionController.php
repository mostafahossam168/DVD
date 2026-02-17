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
        $this->middleware('permission:read_subscriptions|create_subscriptions|update_subscriptions|delete_subscriptions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_subscriptions', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_subscriptions', ['only' => ['edit', 'update']]);
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

        $items = Subscription::with(['user', 'subject'])
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

        $count_all = Subscription::count();
        $count_active = Subscription::active()->count();
        $count_inactive = Subscription::inactive()->count();
        $students = User::students()->active()->get();
        $subjects = Subject::active()->get();

        return view('dashboard.subscriptions.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'students', 'subjects'));
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
        ]);

        // التحقق من أن المستخدم طالب
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'student') {
            return redirect()->back()->with('error', 'يجب اختيار طالب صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر
        $existing = Subscription::where('user_id', $data['user_id'])
            ->where('subject_id', $data['subject_id'])
            ->first();

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
        ]);

        // التحقق من أن المستخدم طالب
        $user = User::findOrFail($data['user_id']);
        if ($user->type !== 'student') {
            return redirect()->back()->with('error', 'يجب اختيار طالب صحيح');
        }

        // التحقق من عدم وجود اشتراك مكرر (عدا الاشتراك الحالي)
        $existing = Subscription::where('user_id', $data['user_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('id', '!=', $id)
            ->first();

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
