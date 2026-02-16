@extends('dashboard.layouts.backend', ['title' => 'الاختبارات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الاختبارات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_quizes')
                        <button type="button" class="main-btn" data-bs-toggle="modal" data-bs-target="#create">
                            اضافة
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @include('dashboard.quizes.create-model')
                    @endcan
                    <a href="{{ route('dashboard.quizes.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.quizes.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.quizes.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                </div>


                <form action="{{ route('dashboard.quizes.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- فلتر القسم -->
                        <div class="col-3">
                            <select name="lecture_id" class="form-select">
                                <option value="">اختيار الدرس</option>
                                @foreach ($lectuers as $lectuer)
                                    <option value="{{ $lectuer->id }}"
                                        {{ request('lecture_id') == $lectuer->id ? 'selected' : '' }}>
                                        {{ $lectuer->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر الحالة -->
                        <div class="col-3">
                            <select name="status" class="form-select">
                                <option value="">اختيار الحالة</option>
                                <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>مفعل</option>
                                <option value="no" {{ request('status') == 'no' ? 'selected' : '' }}>غير مفعل
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <div>
                                <input class="form-control" type="search" id="" value="{{ request('search') }}"
                                    name="search" placeholder="@lang('Search')" />
                            </div>
                        </div>
                        <!-- زر البحث -->
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary">تصفية</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الدرس</th>
                        <th>العنوان</th>
                        <th>الاسئله</th>
                        <th>من</th>
                        <th>الي</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->lecture?->title }}</td>
                            <td> {{ $item->title }}</td>
                            <td>
                                <a href="{{ route('dashboard.questions.index', ['quize_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">{{ $item->questions->count() }}</a>
                            </td>
                            <td>
                                {{ date('h:ia | Y-m-d ', strtotime($item->start_time)) }}
                            </td>
                            <td>
                                {{ date('h:ia | Y-m-d ', strtotime($item->end_time)) }}
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                @can('update_quizes')
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                @endcan
                                @can('delete_quizes')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan
                                @include('dashboard.quizes.delete-model', ['item' => $item])
                                @include('dashboard.quizes.edit-model', ['item' => $item])
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
