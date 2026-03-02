<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OnlineMeeting;
use App\Models\Stage;
use App\Models\Subject;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OnlineMeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_lectuers|create_lectuers|update_lectuers|delete_lectuers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_lectuers', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_lectuers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_lectuers', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = OnlineMeeting::with(['subject.grade.stage'])
            ->where('teacher_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('dashboard.online-meetings.index', compact('items'));
    }

    public function create()
    {
        $stages = Stage::active()->get();

        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subjects = Subject::whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->active()->get();
        } else {
            $subjects = Subject::active()->get();
        }

        return view('dashboard.online-meetings.create', compact('stages', 'subjects'));
    }

    public function store(Request $request, ZoomService $zoom)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'nullable|integer|min:15',
            'stage_id' => 'required|exists:stages,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $startTime = Carbon::parse($data['start_time']);

        // تأكيد أن المدرس يضيف محاضرة لمادة من مواده فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subject = Subject::findOrFail($data['subject_id']);
            if (! $subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بإضافة محاضرة لهذه المادة');
            }

            // تأمين stage و grade من المادة نفسها
            $data['grade_id'] = optional($subject->grade)->id;
            $data['stage_id'] = optional(optional($subject->grade)->stage)->id;
        }

        $zoomResponse = $zoom->createMeeting([
            'topic' => $data['topic'],
            'start_time' => $startTime,
            'duration' => $data['duration'] ?? 60,
        ]);

        OnlineMeeting::create([
            'teacher_id' => auth()->id(),
            'stage_id' => $data['stage_id'] ?? null,
            'grade_id' => $data['grade_id'] ?? null,
            'subject_id' => $data['subject_id'],
            'topic' => $data['topic'],
            'start_time' => $startTime,
            'duration' => $data['duration'] ?? 60,
            'zoom_meeting_id' => $zoomResponse['id'] ?? null,
            'join_url' => $zoomResponse['join_url'] ?? null,
            'start_url' => $zoomResponse['start_url'] ?? null,
            'password' => $zoomResponse['password'] ?? null,
            'status' => 'scheduled',
        ]);

        return redirect()->route('dashboard.online-meetings.index')
            ->with('success', 'تم إنشاء المحاضرة الأونلاين بنجاح.');
    }

    public function edit(OnlineMeeting $onlineMeeting)
    {
        $this->authorizeOwner($onlineMeeting);

        $stages = Stage::active()->get();

        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subjects = Subject::whereHas('teachers', function ($q) {
                $q->where('users.id', auth()->id());
            })->active()->get();
        } else {
            $subjects = Subject::active()->get();
        }

        return view('dashboard.online-meetings.edit', [
            'item' => $onlineMeeting,
            'stages' => $stages,
            'subjects' => $subjects,
        ]);
    }

    public function update(Request $request, OnlineMeeting $onlineMeeting, ZoomService $zoom)
    {
        $this->authorizeOwner($onlineMeeting);

        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'nullable|integer|min:15',
            'stage_id' => 'required|exists:stages,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $startTime = Carbon::parse($data['start_time']);

        // تأكيد أن المدرس يعدل محاضرة لمادة من مواده فقط
        if (auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin')) {
            $subject = Subject::findOrFail($data['subject_id']);
            if (! $subject->teachers()->where('users.id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'غير مصرح لك بتعديل محاضرة لهذه المادة');
            }

            $data['grade_id'] = optional($subject->grade)->id;
            $data['stage_id'] = optional(optional($subject->grade)->stage)->id;
        }

        if ($onlineMeeting->zoom_meeting_id) {
            $zoom->updateMeeting($onlineMeeting->zoom_meeting_id, [
                'topic' => $data['topic'],
                'start_time' => $startTime,
                'duration' => $data['duration'] ?? $onlineMeeting->duration,
            ]);
        }

        $onlineMeeting->update([
            'stage_id' => $data['stage_id'] ?? null,
            'grade_id' => $data['grade_id'] ?? null,
            'subject_id' => $data['subject_id'],
            'topic' => $data['topic'],
            'start_time' => $startTime,
            'duration' => $data['duration'] ?? $onlineMeeting->duration,
        ]);

        return redirect()->route('dashboard.online-meetings.index')
            ->with('success', 'تم تحديث المحاضرة الأونلاين بنجاح.');
    }

    public function destroy(OnlineMeeting $onlineMeeting, ZoomService $zoom)
    {
        $this->authorizeOwner($onlineMeeting);

        if ($onlineMeeting->zoom_meeting_id) {
            $zoom->deleteMeeting($onlineMeeting->zoom_meeting_id);
        }

        $onlineMeeting->delete();

        return redirect()->route('dashboard.online-meetings.index')
            ->with('success', 'تم حذف المحاضرة الأونلاين بنجاح.');
    }

    protected function authorizeOwner(OnlineMeeting $meeting): void
    {
        abort_unless($meeting->teacher_id === auth()->id(), 403);
    }
}
