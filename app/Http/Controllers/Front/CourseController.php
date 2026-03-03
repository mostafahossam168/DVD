<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use App\Models\Lecture;
use App\Models\PaymentMethod;
use App\Models\Quize;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $stages = Stage::active()
            ->with(['grades' => function ($q) {
                $q->active()->with(['subjects' => function ($q) {
                    $q->active();
                }]);
            }])
            ->orderBy('name')
            ->get();

        $student = Auth::check() && Auth::user()->type === 'student' ? Auth::user() : null;
        $subscribedSubjectIds = [];
        $favoriteSubjectIds = [];

        if ($student) {
            $subscribedSubjectIds = $student->courseSubscriptions()
                ->active()
                ->pluck('subject_id')
                ->all();
            $favoriteSubjectIds = $student->favorites()->pluck('subject_id')->all();
        }

        return view('front.courses.index', [
            'stages' => $stages,
            'subscribedSubjectIds' => $subscribedSubjectIds,
            'favoriteSubjectIds' => $favoriteSubjectIds,
        ]);
    }

    public function showSubject(Subject $subject)
    {
        abort_unless($subject->status, 404);

        $subject->load(['grade.stage', 'teachers']);

        $lectures = Lecture::active()
            ->where('subject_id', $subject->id)
            ->withCount(['materials' => fn ($q) => $q->active()])
            ->with('subject')
            ->orderBy('title')
            ->get();

        $lectureIds = $lectures->pluck('id')->toArray();
        $quizzesByLecture = \App\Models\Quize::active()
            ->whereIn('lecture_id', $lectureIds)
            ->pluck('id', 'lecture_id');
        $lectures = $lectures->map(function ($lecture) use ($quizzesByLecture) {
            $lecture->has_quiz = isset($quizzesByLecture[$lecture->id]);
            $lecture->quiz_id = $quizzesByLecture[$lecture->id] ?? null;
            return $lecture;
        });
        $firstLectureWithQuiz = $lectures->first(fn ($l) => $l->has_quiz);

        $student = Auth::check() && Auth::user()->type === 'student' ? Auth::user() : null;

        $hasActiveSubscription = false;

        if ($student) {
            $hasActiveSubscription = Subscription::active()
                ->where('user_id', $student->id)
                ->where('subject_id', $subject->id)
                ->exists();
        }

        $paymentMethods = PaymentMethod::active()->orderBy('name')->get();

        $reviews = CourseReview::active()
            ->where('subject_id', $subject->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        $hasRated = false;
        $canRate = false;
        $isFavorite = false;
        if ($student && $hasActiveSubscription) {
            $hasRated = CourseReview::where('user_id', $student->id)
                ->where('subject_id', $subject->id)
                ->exists();
            $canRate = ! $hasRated;
        }
        if ($student) {
            $isFavorite = \App\Models\Favorite::where('user_id', $student->id)
                ->where('subject_id', $subject->id)
                ->exists();
        }

        $onlineMeetings = \App\Models\OnlineMeeting::where('subject_id', $subject->id)
            ->orderBy('start_time')
            ->get();

        return view('front.courses.subject', [
            'subject' => $subject,
            'lectures' => $lectures,
            'firstLectureWithQuiz' => $firstLectureWithQuiz,
            'reviews' => $reviews,
            'student' => $student,
            'hasActiveSubscription' => $hasActiveSubscription,
            'paymentMethods' => $paymentMethods,
            'hasRated' => $hasRated,
            'canRate' => $canRate,
            'isFavorite' => $isFavorite,
            'onlineMeetings' => $onlineMeetings,
        ]);
    }

    public function myCourses()
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login');
        }

        $subscriptions = $user->courseSubscriptions()
            ->active()
            ->with(['subject.grade.stage'])
            ->latest()
            ->get();

        $favoriteSubjectIds = $user->favorites()->pluck('subject_id')->all();

        return view('front.courses.my', [
            'subscriptions' => $subscriptions,
            'favoriteSubjectIds' => $favoriteSubjectIds,
        ]);
    }

    public function subscribe(Request $request, Subject $subject)
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        abort_unless($subject->status, 404);

        $activeCodes = PaymentMethod::active()->pluck('code')->toArray();
        $rules = [
            'period_type' => 'nullable|in:term,month',
            'term_number' => 'nullable|integer|min:1|max:3',
            'payment_method' => 'required|string|in:' . implode(',', $activeCodes),
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
        if ($request->input('payment_method') === 'vodafone_cash') {
            $rules['payment_phone'] = 'required|string|max:30';
            $rules['payment_reference'] = 'required|string|max:191';
        } else {
            $rules['payment_phone'] = 'nullable|string|max:30';
            $rules['payment_reference'] = 'nullable|string|max:191';
        }

        $data = $request->validate($rules);

        $periodType = $data['period_type'] ?? 'term';

        $payload = [
            'user_id' => $user->id,
            'subject_id' => $subject->id,
            'status' => false,
            'period_type' => $periodType,
            'term_number' => null,
            'start_date' => null,
            'end_date' => null,
        ];

        if ($periodType === 'term') {
            $payload['term_number'] = $data['term_number'] ?? 1;
        } else {
            $start = now()->startOfDay();
            $end = (clone $start)->addMonth();
            $payload['start_date'] = $start;
            $payload['end_date'] = $end;
        }

        $payload['payment_method'] = $data['payment_method'];
        $payload['payment_phone'] = $data['payment_phone'] ?? null;
        $payload['payment_reference'] = $data['payment_reference'] ?? null;
        $payload['payment_status'] = 'pending';

        if ($request->hasFile('payment_screenshot')) {
            $payload['payment_screenshot'] = store_file($request->file('payment_screenshot'), 'subscriptions');
        } else {
            $payload['payment_screenshot'] = null;
        }

        $existingQuery = Subscription::where('user_id', $payload['user_id'])
            ->where('subject_id', $payload['subject_id'])
            ->where('period_type', $periodType);

        if ($periodType === 'term') {
            $existingQuery->where('term_number', $payload['term_number']);
        } else {
            $existingQuery
                ->whereDate('start_date', $payload['start_date'])
                ->whereDate('end_date', $payload['end_date']);
        }

        $existing = $existingQuery->first();

        if ($existing) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'أنت مشترك بالفعل في هذا الكورس لهذه الفترة.');
        }

        Subscription::create($payload);

        return redirect()
            ->route('front.courses.subject', $subject)
            ->with('success', 'تم إرسال طلب الاشتراك. سيتم مراجعته من الإدارة.');
    }

    public function rate(Request $request, Subject $subject)
    {
        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك كطالب أولاً.');
        }

        abort_unless($subject->status, 404);

        $hasActiveSubscription = Subscription::active()
            ->where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (! $hasActiveSubscription) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'يجب الاشتراك في الكورس أولاً لتقييمه.');
        }

        $existing = CourseReview::where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->first();

        if ($existing) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'لقد قيّمت هذا الكورس مسبقاً.');
        }

        $data = $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'review_text' => 'required|string|min:10',
        ]);

        CourseReview::create([
            'user_id' => $user->id,
            'subject_id' => $subject->id,
            'name' => trim($user->f_name . ' ' . $user->l_name),
            'subject_field' => $subject->name,
            'rating' => $data['rating'],
            'review_text' => $data['review_text'],
            'status' => true,
        ]);

        return redirect()
            ->route('front.courses.subject', $subject)
            ->with('success', 'شكراً لتقييمك! تم حفظ تقييمك بنجاح.');
    }

    public function showLesson(Subject $subject, Lecture $lecture)
    {
        abort_unless($subject->status, 404);

        if ($lecture->subject_id !== $subject->id || ! $lecture->status) {
            abort(404);
        }

        $user = Auth::user();

        if (! $user || $user->type !== 'student') {
            return redirect()->route('front.login')->with('error', 'من فضلك سجّل دخولك لمشاهدة الدرس.');
        }

        $hasActiveSubscription = Subscription::active()
            ->where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (! $hasActiveSubscription) {
            return redirect()
                ->route('front.courses.subject', $subject)
                ->with('error', 'يجب الاشتراك في الكورس أولاً لمشاهدة الدرس.');
        }

        $embedUrl = $this->makeYoutubeEmbedUrl($lecture->link);

        $quiz = Quize::active()
            ->where('lecture_id', $lecture->id)
            ->withCount('questions')
            ->first();

        $hasQuizResult = false;
        if ($quiz && $user && $user->type === 'student') {
            $hasQuizResult = \App\Models\QuizResult::where('user_id', $user->id)
                ->where('quize_id', $quiz->id)
                ->exists();
        }

        $materials = \App\Models\Material::active()
            ->where('lecture_id', $lecture->id)
            ->orderBy('title')
            ->get();

        return view('front.courses.lesson', [
            'subject' => $subject->load(['grade.stage']),
            'lecture' => $lecture,
            'embedUrl' => $embedUrl,
            'quiz' => $quiz,
            'hasQuizResult' => $hasQuizResult,
            'materials' => $materials,
        ]);
    }

    protected function makeYoutubeEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $parsed = parse_url($url);
        if (! $parsed || empty($parsed['host'])) {
            return null;
        }

        $host = $parsed['host'];

        // youtu.be/VIDEO_ID
        if (str_contains($host, 'youtu.be')) {
            $id = ltrim($parsed['path'] ?? '', '/');
            return $id ? 'https://www.youtube.com/embed/' . $id : null;
        }

        // youtube.com/watch?v=VIDEO_ID
        if (str_contains($host, 'youtube.com')) {
            if (isset($parsed['path']) && $parsed['path'] === '/watch') {
                if (! empty($parsed['query'])) {
                    parse_str($parsed['query'], $query);
                    if (! empty($query['v'])) {
                        return 'https://www.youtube.com/embed/' . $query['v'];
                    }
                }
            }

            // youtube.com/embed/VIDEO_ID
            if (isset($parsed['path']) && str_starts_with($parsed['path'], '/embed/')) {
                return 'https://www.youtube.com' . $parsed['path'];
            }
        }

        return null;
    }
}

