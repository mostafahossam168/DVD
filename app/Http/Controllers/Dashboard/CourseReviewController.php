<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subject;
use App\Models\CourseReview;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CourseReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_course_reviews|create_course_reviews|update_course_reviews|delete_course_reviews', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_course_reviews', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_course_reviews', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_course_reviews', ['only' => ['destroy']]);
    }

    public function index()
    {
        $status = request('status');
        $search = request('search');

        $items = CourseReview::with('subject')
            ->when($search, fn ($q) => $q->whereAny(['name', 'subject_field', 'review_text'], 'LIKE', "%$search%"))
            ->when($status, function ($q) use ($status) {
                if ($status === 'yes') $q->active();
                if ($status === 'no') $q->where('status', false);
            })
            ->latest()
            ->paginate(20);

        $count_all = CourseReview::count();
        $count_active = CourseReview::active()->count();
        $count_inactive = CourseReview::where('status', false)->count();

        return view('dashboard.course-reviews.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    public function create()
    {
        $subjects = Subject::active()->orderBy('name')->get();
        return view('dashboard.course-reviews.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject_field' => 'nullable|string|max:100',
            'rating' => 'required|numeric|min:0|max:5',
            'review_text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'subject_id' => 'nullable|exists:subjects,id',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = store_file($request->file('image'), 'course-reviews');
        }

        CourseReview::create($data);
        return redirect()->route('dashboard.course-reviews.index')->with('success', 'تم إضافة التقييم بنجاح');
    }

    public function edit(CourseReview $courseReview)
    {
        $subjects = Subject::active()->orderBy('name')->get();
        return view('dashboard.course-reviews.edit', ['item' => $courseReview, 'subjects' => $subjects]);
    }

    public function update(Request $request, CourseReview $courseReview)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject_field' => 'nullable|string|max:100',
            'rating' => 'required|numeric|min:0|max:5',
            'review_text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'subject_id' => 'nullable|exists:subjects,id',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($courseReview->image) {
                delete_file($courseReview->image);
            }
            $data['image'] = store_file($request->file('image'), 'course-reviews');
        }

        $courseReview->update($data);
        return redirect()->route('dashboard.course-reviews.index')->with('success', 'تم تحديث التقييم بنجاح');
    }

    public function destroy(CourseReview $courseReview)
    {
        if ($courseReview->image) {
            delete_file($courseReview->image);
        }
        $courseReview->delete();
        return redirect()->route('dashboard.course-reviews.index')->with('success', 'تم الحذف بنجاح');
    }
}
