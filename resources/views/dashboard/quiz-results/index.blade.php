@extends('dashboard.layouts.backend', ['title' => 'نتائج الاختبارات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">نتائج الاختبارات</div>
        </div>

        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>الاختبار</th>
                        <th>المادة</th>
                        <th>الدرجة</th>
                        <th>تاريخ الحل</th>
                        <th>عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        @php
                            $quiz = $result->quiz;
                            $subject = $quiz?->lecture?->subject;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->user?->full_name ?? '-' }}</td>
                            <td>{{ $quiz?->title ?? '-' }}</td>
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
                            <td>
                                <a href="{{ route('dashboard.quiz-results.show', $result->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    عرض الإجابات
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>
        {{ $results->links() }}
    </div>
@endsection

