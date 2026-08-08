<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreOnlineMeetingRequest;
use App\Http\Requests\Dashboard\UpdateOnlineMeetingRequest;
use App\Models\OnlineMeeting;
use App\Models\Stage;
use App\Models\Subject;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Throwable;

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
            ->latest()
            ->paginate(20);

        return view('dashboard.online-meetings.index', compact('items'));
    }

    public function create()
    {
        $stages = Stage::active()->get();
        $subjects = Subject::active()->get();

        return view('dashboard.online-meetings.create', compact('stages', 'subjects'));
    }

    public function store(StoreOnlineMeetingRequest $request, ZoomService $zoom)
    {
        $data = $request->validated();

        $startTime = Carbon::parse($data['start_time']);

        $zoomResponse = $zoom->createMeeting([
            'topic' => $data['topic'],
            'start_time' => $startTime,
            'duration' => $data['duration'] ?? 60,
        ]);

        OnlineMeeting::create([
            'teacher_id' => Auth::id(),
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
        $stages = Stage::active()->get();
        $subjects = Subject::active()->get();

        return view('dashboard.online-meetings.edit', [
            'item' => $onlineMeeting,
            'stages' => $stages,
            'subjects' => $subjects,
        ]);
    }

    public function update(UpdateOnlineMeetingRequest $request, OnlineMeeting $onlineMeeting, ZoomService $zoom)
    {
        $data = $request->validated();

        $startTime = Carbon::parse($data['start_time']);

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
        $zoomDeleteFailed = false;
        if ($onlineMeeting->zoom_meeting_id) {
            try {
                $zoom->deleteMeeting($onlineMeeting->zoom_meeting_id);
            } catch (Throwable $e) {
                // لا نمنع حذف السجل المحلي إذا فشل حذف اجتماع زووم (مثلاً مشكلة صلاحيات التوكن).
                $zoomDeleteFailed = true;
            }
        }

        $onlineMeeting->delete();

        $message = $zoomDeleteFailed
            ? 'تم حذف المحاضرة من النظام، لكن تعذر حذف اجتماع Zoom بسبب صلاحيات التوكن.'
            : 'تم حذف المحاضرة الأونلاين بنجاح.';

        return redirect()->route('dashboard.online-meetings.index')->with('success', $message);
    }
}
