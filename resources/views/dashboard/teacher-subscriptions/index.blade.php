@extends('dashboard.layouts.backend', ['title' => 'اشتراكات المدرسين'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">اشتراكات المدرسين</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_teacher_subscriptions')
                        <a href="{{ route('dashboard.teacher-subscriptions.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.teacher-subscriptions.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ $count_active }}</a>
                    <a href="{{ route('dashboard.teacher-subscriptions.index', ['status' => 'no']) }}"
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

        @if(auth()->user()->hasRole('admin'))
        <div class="row g-3 mb-3">
            @if($teachers->count() > 0)
            <div class="col-12 col-md-3">
                <select name="teacher_id" class="form-select" onchange="filterSubscriptions()">
                    <option value="">جميع المدرسين</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" @selected(request('teacher_id') == $teacher->id)>
                            {{ $teacher->fullname }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($plans->count() > 0)
            <div class="col-12 col-md-3">
                <select name="plan_id" class="form-select" onchange="filterSubscriptions()">
                    <option value="">جميع الخطط</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        @endif

        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المدرس</th>
                        <th>الخطة</th>
                        <th>السعر</th>
                        <th>حد المواد</th>
                        <th>حد الطلاب</th>
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
                            <td>{{ $item->plan->name }}</td>
                            <td>{{ number_format($item->plan->price, 2) }} ر.س</td>
                            <td>{{ $item->plan->subjects_limit }}</td>
                            <td>{{ $item->plan->students_limit }}</td>
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
                                    @can('update_teacher_subscriptions')
                                        @if(auth()->user()->hasRole('admin') || $item->user_id == auth()->id())
                                            <a href="{{ route('dashboard.teacher-subscriptions.edit', $item->id) }}"
                                                class="btn btn-primary btn-sm text-white mx-1">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('delete_teacher_subscriptions')
                                        @if(auth()->user()->hasRole('admin') || $item->user_id == auth()->id())
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                                @include('dashboard.teacher-subscriptions.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>

    @if(auth()->user()->hasRole('admin'))
    <script>
        function filterSubscriptions() {
            const teacherId = document.querySelector('select[name="teacher_id"]').value;
            const planId = document.querySelector('select[name="plan_id"]').value;
            const url = new URL(window.location.href);
            
            if (teacherId) {
                url.searchParams.set('teacher_id', teacherId);
            } else {
                url.searchParams.delete('teacher_id');
            }
            
            if (planId) {
                url.searchParams.set('plan_id', planId);
            } else {
                url.searchParams.delete('plan_id');
            }
            
            window.location.href = url.toString();
        }
    </script>
    @endif
@endsection
