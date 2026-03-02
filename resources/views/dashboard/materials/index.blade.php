@extends('dashboard.layouts.backend', [
    'title' => ' الملفات',
])
@section('contant')
    <div class="main-side">
        <x-alert-component></x-alert-component>
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>/
            <div class="large">
                الملفات
            </div>
        </div>
        <div class="bar-options d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="btn-holder d-flex align-items-center justify-content-start gap-1 mb-2">
                @can('create_materials')
                    <button type="button" class="main-btn" data-bs-toggle="modal" data-bs-target="#create">
                        اضافة
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    @include('dashboard.materials.create-modal')
                @endcan
                <a href="{{ route('dashboard.materials.index') }}" type="button" class="main-btn btn-main-color">الكل:
                    {{ $count_all }}</a>
                <a href="{{ route('dashboard.materials.index', ['status' => 'yes']) }}" type="button"
                    class="btn btn-success">مفعل:{{ $count_active }}</a>
                <a href="{{ route('dashboard.materials.index', ['status' => 'no']) }}" type="button"
                    class="btn btn-danger">غير
                    مفعل:{{ $count_inactive }}</a>
                {{-- <a href="{{ route('dashboard.materials.export', [
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
        
        @if(isset($lectuers) && $lectuers->count() > 0)
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-3">
                <select name="lecture_id" class="form-select" onchange="filterMaterials()">
                    <option value="">جميع الدروس</option>
                    @foreach($lectuers as $lecture)
                        <option value="{{ $lecture->id }}" @selected(request('lecture_id') == $lecture->id)>
                            {{ $lecture->title }} - {{ $lecture->subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الدرس</th>
                        <th>الملف</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->lecture->title }}</td>
                            {{-- <td>{{ $item->file }}</td> --}}
                            <td><a target="_blank" href=" {{ display_file($item->file) }}" class="btn btn-sm btn-info"> <i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            {{-- <td>
                                <a href="{{ route('dashboard.grades.index', ['stage_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">{{ $item->grades->count() }}</a>
                            </td> --}}
                            <td class="d-flex gap-2">
                                @can('update_materials')
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                @endcan
                                @can('delete_materials')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan
                                @include('dashboard.materials.delete-modal', ['item' => $item])
                                @include('dashboard.materials.edit-modal', ['item' => $item])

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
    
    @if(isset($lectuers) && $lectuers->count() > 0)
    <script>
        function filterMaterials() {
            const el = document.querySelector('.bar-options select[name="lecture_id"]');
            if (!el) return;
            const lectureId = el.value;
            const url = new URL(window.location.href);
            if (lectureId) url.searchParams.set('lecture_id', lectureId);
            else url.searchParams.delete('lecture_id');
            window.location.href = url.toString();
        }
    </script>
    @endif

    @if(isset($stages) && $stages->count() > 0)
    @push('scripts')
    <script>
        $(function() {
            // المرحلة -> الصف -> المادة -> الدرس
            $(document).on('change', '.material-stage-select', function() {
                var $form = $(this).closest('form');
                var stage_id = $(this).val();
                $form.find('.material-grade-select').empty().append('<option value="">-- اختر --</option>');
                $form.find('.material-subject-select').empty().append('<option value="">-- اختر --</option>');
                $form.find('.material-lecture-select').empty().append('<option value="">-- اختر المرحلة والصف والمادة أولاً --</option>');
                if (!stage_id) return;
                var url = "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stage_id);
                $.get(url, function(data) {
                    var items = typeof data === 'string' ? JSON.parse(data) : data;
                    $.each(items, function(name, id) {
                        $form.find('.material-grade-select').append('<option value="' + id + '">' + name + '</option>');
                    });
                });
            });
            $(document).on('change', '.material-grade-select', function() {
                var $form = $(this).closest('form');
                var grade_id = $(this).val();
                $form.find('.material-subject-select').empty().append('<option value="">-- اختر --</option>');
                $form.find('.material-lecture-select').empty().append('<option value="">-- اختر المرحلة والصف والمادة أولاً --</option>');
                if (!grade_id) return;
                var url = "{{ route('dashboard.getsubjects', ':id') }}".replace(':id', grade_id);
                $.get(url, function(data) {
                    var items = typeof data === 'string' ? JSON.parse(data) : data;
                    $.each(items, function(name, id) {
                        $form.find('.material-subject-select').append('<option value="' + id + '">' + name + '</option>');
                    });
                });
            });
            $(document).on('change', '.material-subject-select', function() {
                var $form = $(this).closest('form');
                var subject_id = $(this).val();
                $form.find('.material-lecture-select').empty().append('<option value="">-- اختر --</option>');
                if (!subject_id) return;
                var url = "{{ route('dashboard.getlectures', ':id') }}".replace(':id', subject_id);
                $.get(url, function(data) {
                    var items = typeof data === 'string' ? JSON.parse(data) : data;
                    $.each(items, function(title, id) {
                        $form.find('.material-lecture-select').append('<option value="' + id + '">' + title + '</option>');
                    });
                });
            });
            // تعبئة بيانات التعديل عند فتح المودال
            $('.modal[id^="edit"]').on('shown.bs.modal', function() {
                var $modal = $(this);
                var stageId = $modal.data('stage-id');
                var gradeId = $modal.data('grade-id');
                var subjectId = $modal.data('subject-id');
                var lectureId = $modal.data('lecture-id');
                if (!stageId) return;
                var $form = $modal.find('form');
                $form.find('select[name="stage_id"]').val(stageId);
                var url = "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stageId);
                $.get(url, function(data) {
                    var items = typeof data === 'string' ? JSON.parse(data) : data;
                    $form.find('.material-grade-select').empty().append('<option value="">-- اختر --</option>');
                    $.each(items, function(name, id) {
                        $form.find('.material-grade-select').append('<option value="' + id + '"' + (id == gradeId ? ' selected' : '') + '>' + name + '</option>');
                    });
                    url = "{{ route('dashboard.getsubjects', ':id') }}".replace(':id', gradeId);
                    $.get(url, function(data2) {
                        var items2 = typeof data2 === 'string' ? JSON.parse(data2) : data2;
                        $form.find('.material-subject-select').empty().append('<option value="">-- اختر --</option>');
                        $.each(items2, function(name, id) {
                            $form.find('.material-subject-select').append('<option value="' + id + '"' + (id == subjectId ? ' selected' : '') + '>' + name + '</option>');
                        });
                        url = "{{ route('dashboard.getlectures', ':id') }}".replace(':id', subjectId);
                        $.get(url, function(data3) {
                            var items3 = typeof data3 === 'string' ? JSON.parse(data3) : data3;
                            $form.find('.material-lecture-select').empty().append('<option value="">-- اختر --</option>');
                            $.each(items3, function(title, id) {
                                $form.find('.material-lecture-select').append('<option value="' + id + '"' + (id == lectureId ? ' selected' : '') + '>' + title + '</option>');
                            });
                        });
                    });
                });
            });
        });
    </script>
    @endpush
    @endif
@endsection
