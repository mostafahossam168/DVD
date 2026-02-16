@extends('dashboard.layouts.backend', ['title' => 'الدروس'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الدروس</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_teachers')
                        <a href="{{ route('dashboard.lectuers.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.lectuers.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.lectuers.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ $count_active }}</a>
                    <a href="{{ route('dashboard.lectuers.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين :{{ $count_inactive }}</a>
                    {{-- <a href="{{ route('dashboard.lectuers.export', [
                        'status' => request('status'),
                        'search' => request('search'),
                    ]) }}"
                        class="main-btn btn-sm  bg-warning ">
                        <i class="fa-solid fa-file-excel fs-5"></i>تصدير Excel</a> --}}
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
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المرحله الدراسيه</th>
                        <th>الصف الدراسى</th>
                        <th>الماده</th>
                        <th>الوصف</th>
                        <th>اللينك</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->title }}</td>
                            <td> {{ $item->subject->grade->stage->name }}</td>
                            <td> {{ $item->subject->grade->name }}</td>
                            <td> {{ $item->subject->name }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#showDes{{ $item->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                @include('dashboard.lectuers.show-description-model', ['item' => $item])
                            </td>
                            <td><a target="_blank" href=" {{ $item->link }}" class="btn btn-sm btn-info"> <i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            {{-- <td><a href="{{ route('dashboard.courses.index', ['teacher_id' => $item->id]) }}"
                                    class="btn btn-sm btn-info">{{ $item->teacherCourses()->count() }}</a>
                            </td> --}}
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_lectuers')
                                        <a href="{{ route('dashboard.lectuers.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_lectuers')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.lectuers.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}

    </div>
@endsection
