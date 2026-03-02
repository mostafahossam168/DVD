@extends('front.layouts.front', ['title' => 'اختباراتي'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">الاختبارات التي قمت بحلّها</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($results->count())
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاختبار</th>
                                <th>المادة</th>
                                <th>الدرجة</th>
                                <th>تاريخ الحل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                                @php
                                    $quiz = $result->quiz;
                                    $subject = $quiz?->lecture?->subject;
                                @endphp
                                <tr>
                                    <td>{{ $results->firstItem() + $index }}</td>
                                    <td>
                                        @if ($quiz)
                                            <a href="{{ route('front.quizzes.review', $quiz) }}">
                                                {{ $quiz->title }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subject)
                                            {{ $subject->name }}
                                            @if ($subject->grade)
                                                - {{ $subject->grade->name }}
                                                - {{ $subject->grade->stage?->name }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $result->score }} / {{ $result->max_score }}</td>
                                    <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $results->links() }}
            @else
                <p class="text-muted">
                    لم تقم بحل أي اختبارات بعد.
                </p>
            @endif
        </div>
    </section>
@endsection

