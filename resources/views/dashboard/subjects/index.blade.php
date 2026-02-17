@extends('dashboard.layouts.backend', [
    'title' => 'المواد الدراسيه',
])
@section('contant')
    <div class="main-side">
        <x-alert-component></x-alert-component>
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>/
            <div class="large">
                المواد الدراسيه
            </div>
        </div>
        <div class="bar-options d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="btn-holder d-flex align-items-center justify-content-start gap-1 mb-2">
                @can('create_subjects')
                    <button type="button" class="main-btn" data-bs-toggle="modal" data-bs-target="#create">
                        اضافة
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    @include('dashboard.subjects.create-modal')
                @endcan
                <a href="{{ route('dashboard.subjects.index') }}" type="button" class="main-btn btn-main-color">الكل:
                    {{ $count_all }}</a>
                <a href="{{ route('dashboard.subjects.index', ['status' => 'yes']) }}" type="button"
                    class="btn btn-success">مفعل:{{ $count_active }}</a>
                <a href="{{ route('dashboard.subjects.index', ['status' => 'no']) }}" type="button"
                    class="btn btn-danger">غير مفعل:{{ $count_inactive }}</a>
                {{-- <a href="{{ route('dashboard.subjects.export', [
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
                <select name="stage_id" id="filter_stage_id" class="form-select" onchange="filterSubjects()">
                    <option value="">جميع المراحل</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(request('stage_id') == $stage->id)>
                            {{ $stage->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="grade_id" id="filter_grade_id" class="form-select" onchange="filterSubjects()">
                    <option value="">جميع الصفوف</option>
                    @foreach($grades as $grade)
                        @if(!request('stage_id') || $grade->stage_id == request('stage_id'))
                            <option value="{{ $grade->id }}" @selected(request('grade_id') == $grade->id)>
                                {{ $grade->name }}
                            </option>
                        @endif
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
                        <th>الصوره</th>
                        <th>الحالة</th>
                        <th>الصف الدراسي</th>
                        <th>المرحله الدراسيه</th>
                        <th>المعلمين</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td> <img style="width: 60px; height:60px" src="{{ display_file($item->image) }}"
                                    alt="" srcset=""></td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>{{ $item->grade->name }}</td>
                            <td>{{ $item->grade->stage->name }}</td>
                            <td>
                                <a href="{{ route('dashboard.teachers.index', ['subject_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">{{ $item->teachers()->count() }}</a>
                            </td>
                            <td class="d-flex gap-2">
                                @can('update_subjects')
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                @endcan
                                @can('delete_subjects')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan
                                @include('dashboard.subjects.delete-modal', ['item' => $item])
                                @include('dashboard.subjects.edit-modal', ['item' => $item])

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // فلترة المواد
            function filterSubjects() {
                const stageId = document.getElementById('filter_stage_id').value;
                const gradeId = document.getElementById('filter_grade_id').value;
                const url = new URL(window.location.href);
                
                if (stageId) {
                    url.searchParams.set('stage_id', stageId);
                } else {
                    url.searchParams.delete('stage_id');
                }
                
                if (gradeId) {
                    url.searchParams.set('grade_id', gradeId);
                } else {
                    url.searchParams.delete('grade_id');
                }
                
                window.location.href = url.toString();
            }
            
            // تحديث الصفوف عند تغيير المرحلة في الفلتر
            $('#filter_stage_id').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#filter_grade_id');
                
                if (stage_id) {
                    var url = "{{ route('dashboard.getgrade', ':id') }}";
                    url = url.replace(':id', stage_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            gradeSelect.empty();
                            gradeSelect.append(
                                "<option value=''>جميع الصفوف</option>"
                            );

                            $.each(data, function(key, value) {
                                gradeSelect.append(
                                    '<option value="' + value + '">' + key + '</option>'
                                );
                            });
                            
                            // تطبيق الفلترة بعد تحديث الصفوف
                            filterSubjects();
                        },
                    });
                } else {
                    gradeSelect.empty();
                    gradeSelect.append(
                        "<option value=''>جميع الصفوف</option>"
                    );
                    @foreach($grades as $grade)
                        gradeSelect.append(
                            '<option value="{{ $grade->id }}">{{ $grade->name }}</option>'
                        );
                    @endforeach
                    
                    // تطبيق الفلترة
                    filterSubjects();
                }
            });
            
            // للإنشاء
            $('#create select[name="stage_id"]').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#create select[name="grade_id"]');
                
                if (stage_id) {
                    var url = "{{ route('dashboard.getgrade', ':id') }}";
                    url = url.replace(':id', stage_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            gradeSelect.empty();
                            gradeSelect.append(
                                "<option selected disabled>-- اختر --</option>"
                            );

                            $.each(data, function(key, value) {
                                gradeSelect.append(
                                    '<option value="' + value + '">' + key + '</option>'
                                );
                            });
                        },
                    });
                } else {
                    gradeSelect.empty();
                    gradeSelect.append(
                        "<option selected disabled>-- اختر المرحلة أولاً --</option>"
                    );
                }
            });

            // للتعديل - لكل modal
            @foreach($items as $item)
            $('#edit{{ $item->id }} select[name="stage_id"]').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#edit{{ $item->id }} select[name="grade_id"]');
                
                if (stage_id) {
                    var url = "{{ route('dashboard.getgrade', ':id') }}";
                    url = url.replace(':id', stage_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var currentGradeId = {{ $item->grade_id }};
                            gradeSelect.empty();
                            gradeSelect.append(
                                "<option selected disabled>-- اختر --</option>"
                            );

                            $.each(data, function(key, value) {
                                var selected = (value == currentGradeId) ? 'selected' : '';
                                gradeSelect.append(
                                    '<option value="' + value + '" ' + selected + '>' + key + '</option>'
                                );
                            });
                        },
                    });
                } else {
                    gradeSelect.empty();
                    gradeSelect.append(
                        "<option selected disabled>-- اختر المرحلة أولاً --</option>"
                    );
                }
            });
            @endforeach
        });
        
        // دالة الفلترة
        function filterSubjects() {
            const stageId = document.getElementById('filter_stage_id').value;
            const gradeId = document.getElementById('filter_grade_id').value;
            const url = new URL(window.location.href);
            
            if (stageId) {
                url.searchParams.set('stage_id', stageId);
            } else {
                url.searchParams.delete('stage_id');
            }
            
            if (gradeId) {
                url.searchParams.set('grade_id', gradeId);
            } else {
                url.searchParams.delete('grade_id');
            }
            
            window.location.href = url.toString();
        }
    </script>
@endpush
