<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subject;
use App\Models\TeacherWithdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherFinancialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_subscriptions', ['only' => ['index']]);
        $this->middleware('permission:update_subscriptions', ['only' => ['storeWithdrawal']]);
    }

    public function index(Request $request)
    {
        $teacherId = $request->input('teacher_id');

        $teachersQuery = User::teachers()->active();
        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin')) {
            $teachersQuery->where('id', Auth::id());
        } elseif ($teacherId) {
            $teachersQuery->where('id', $teacherId);
        }

        $teachers = $teachersQuery->get();

        $incomeByTeacher = DB::table('subscriptions')
            ->join('subjects', 'subjects.id', '=', 'subscriptions.subject_id')
            ->selectRaw('subjects.teacher_id as teacher_id, SUM(COALESCE(subscriptions.amount_paid, subjects.price, 0)) as total_income')
            ->where('subscriptions.payment_status', 'paid')
            ->where('subscriptions.status', true)
            ->groupBy('subjects.teacher_id')
            ->pluck('total_income', 'teacher_id');

        $withdrawnByTeacher = DB::table('teacher_withdrawals')
            ->selectRaw('teacher_id, SUM(amount) as total_withdrawn')
            ->groupBy('teacher_id')
            ->pluck('total_withdrawn', 'teacher_id');

        $rows = $teachers->map(function ($teacher) use ($incomeByTeacher, $withdrawnByTeacher) {
            $income = (float) ($incomeByTeacher[$teacher->id] ?? 0);
            $withdrawn = (float) ($withdrawnByTeacher[$teacher->id] ?? 0);

            return [
                'teacher' => $teacher,
                'income' => $income,
                'withdrawn' => $withdrawn,
                'net' => $income - $withdrawn,
                'subjects_count' => Subject::where('teacher_id', $teacher->id)->count(),
            ];
        });

        $withdrawals = TeacherWithdrawal::with(['teacher', 'creator'])
            ->when(Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin'), function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->latest('withdrawn_at')
            ->latest()
            ->limit(50)
            ->get();

        $allTeachers = User::teachers()->active()->get();

        return view('dashboard.subscriptions.financials', compact('rows', 'withdrawals', 'allTeachers'));
    }

    public function storeWithdrawal(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:1000'],
            'withdrawn_at' => ['nullable', 'date'],
        ]);

        if (Auth::user()->type === 'teacher' && !Auth::user()->hasRole('admin') && (int) $data['teacher_id'] !== (int) Auth::id()) {
            abort(403, 'غير مصرح لك');
        }

        TeacherWithdrawal::create([
            'teacher_id' => $data['teacher_id'],
            'amount' => $data['amount'],
            'note' => $data['note'] ?? null,
            'withdrawn_at' => $data['withdrawn_at'] ?? now(),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('dashboard.subscriptions.financials')->with('success', 'تم تسجيل عملية السحب بنجاح');
    }
}
