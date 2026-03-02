@extends('dashboard.layouts.backend', ['title' => 'الاشتراكات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الاشتراكات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_subscriptions')
                        <a href="{{ route('dashboard.subscriptions.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.subscriptions.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.subscriptions.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ $count_active }}</a>
                    <a href="{{ route('dashboard.subscriptions.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين :{{ $count_inactive }}</a>
                </div>
            </div>
            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon" />
                    <input type="search" id="" value="{{ request('search') }}" name="search"
                        placeholder="@lang('Search')" />
                </form>
            </div>
        </div>

        <div class="row g-3 mb-3">
            @if($students->count() > 0)
            <div class="col-12 col-md-3">
                <select name="student_id" class="form-select" onchange="filterSubscriptions()">
                    <option value="">جميع الطلاب</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>
                            {{ $student->fullname }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($subjects->count() > 0)
            <div class="col-12 col-md-3">
                <select name="subject_id" class="form-select" onchange="filterSubscriptions()">
                    <option value="">جميع المواد</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected(request('subject_id') == $subject->id)>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>

        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>المادة</th>
                        <th>نوع الاشتراك</th>
                        <th>الفترة</th>
                        <th>الحالة</th>
                        <th>تاريخ الاشتراك</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->fullname }}</td>
                            <td>{{ $item->subject->name }}</td>
                            <td>
                                @if ($item->period_type === 'month')
                                    شهري
                                @else
                                    ترم
                                @endif
                            </td>
                            <td>
                                @if ($item->period_type === 'term')
                                    @if ($item->term_number)
                                        ترم {{ $item->term_number }}
                                    @else
                                        -
                                    @endif
                                @else
                                    @if ($item->start_date && $item->end_date)
                                        من {{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}
                                        إلى {{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}
                                    @else
                                        -
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_subscriptions')
                                        <a href="{{ route('dashboard.subscriptions.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_subscriptions')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.subscriptions.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>

    <script>
        function filterSubscriptions() {
            const studentId = document.querySelector('select[name="student_id"]').value;
            const subjectId = document.querySelector('select[name="subject_id"]').value;
            const url = new URL(window.location.href);
            
            if (studentId) {
                url.searchParams.set('student_id', studentId);
            } else {
                url.searchParams.delete('student_id');
            }
            
            if (subjectId) {
                url.searchParams.set('subject_id', subjectId);
            } else {
                url.searchParams.delete('subject_id');
            }
            
            window.location.href = url.toString();
        }
    </script>
@endsection
