@extends('dashboard.layouts.backend', [
    'title' => 'الصفوف الدراسيه',
])
@section('contant')
    <div class="main-side">
        <x-alert-component></x-alert-component>
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>/
            <div class="large">
                الصفوف الدراسيه
            </div>
        </div>
        <div class="bar-options d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="btn-holder d-flex align-items-center justify-content-start gap-1 mb-2">
                @can('create_grades')
                    <button type="button" class="main-btn" data-bs-toggle="modal" data-bs-target="#create">
                        اضافة
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    @include('dashboard.grades.create-modal')
                @endcan
                <a href="{{ route('dashboard.grades.index') }}" type="button" class="main-btn btn-main-color">الكل:
                    {{ $count_all }}</a>
                <a href="{{ route('dashboard.grades.index', ['status' => 'yes']) }}" type="button"
                    class="btn btn-success">مفعل:{{ $count_active }}</a>
                <a href="{{ route('dashboard.grades.index', ['status' => 'no']) }}" type="button"
                    class="btn btn-danger">غير مفعل:{{ $count_inactive }}</a>
                {{-- <a href="{{ route('dashboard.grades.export', [
                    'status' => request('status'),
                    'search' => request('search'),
                ]) }}"
                    class="main-btn btn-sm  bg-warning ">
                    <i class="fa-solid fa-file-excel fs-5"></i>تصدير Excel</a> --}}
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
            <div class="col-12 col-md-3">
                <select name="stage_id" class="form-select" onchange="filterGrades()">
                    <option value="">جميع المراحل</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(request('stage_id') == $stage->id)>
                            {{ $stage->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>المرحلة الدراسيه</th>
                        <th>المواد الدراسيه</th>

                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>{{ $item->stage->name }}</td>
                            <td>
                                <a href="{{ route('dashboard.subjects.index', ['garde_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">{{ $item->subjects->count() }}</a>
                            </td>
                            <td class="d-flex gap-2">
                                @can('update_grades')
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                @endcan
                                @can('delete_grades')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan
                                @include('dashboard.grades.delete-modal', ['item' => $item])
                                @include('dashboard.grades.edit-modal', ['item' => $item])

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
    
    <script>
        function filterGrades() {
            const stageId = document.querySelector('select[name="stage_id"]').value;
            const url = new URL(window.location.href);
            
            if (stageId) {
                url.searchParams.set('stage_id', stageId);
            } else {
                url.searchParams.delete('stage_id');
            }
            
            window.location.href = url.toString();
        }
    </script>
@endsection
