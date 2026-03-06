@extends('dashboard.layouts.backend', ['title' => 'الملفات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الملفات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الملفات</h1>
        <div class="page-header-actions">
            @can('create_materials')
                <button type="button" class="btn-add-ds" data-bs-toggle="modal" data-bs-target="#create">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </button>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.materials.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.materials.index', array_filter(['status' => 'yes', 'lecture_id' => request('lecture_id')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.materials.index', array_filter(['status' => 'no', 'lecture_id' => request('lecture_id')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            @if(isset($lectuers) && $lectuers->count() > 0)
                <select name="lecture_id" id="filter_lecture_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:180px;margin-inline-start:10px" onchange="filterMaterials()">
                    <option value="">جميع الدروس</option>
                    @foreach($lectuers as $lecture)
                        <option value="{{ $lecture->id }}" @selected(request('lecture_id') == $lecture->id)>{{ $lecture->title }} - {{ $lecture->subject->name ?? '' }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.materials.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('lecture_id'))<input type="hidden" name="lecture_id" value="{{ request('lecture_id') }}">@endif
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث...">
            </form>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
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
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->title }}</span></td>
                        <td style="font-size:.9rem">{{ $item->lecture->title ?? '—' }}</td>
                        <td>
                            <a target="_blank" href="{{ display_file($item->file) }}" class="action-btn-ds edit-ds" title="عرض الملف">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                        </td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_materials')
                                    <button type="button" class="action-btn-ds edit-ds" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                @endcan
                                @can('delete_materials')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد ملفات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($items->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">{{ $items->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @can('create_materials')
        @include('dashboard.materials.create-modal')
    @endcan
    @foreach($items as $item)
        @can('delete_materials')
            @include('dashboard.materials.delete-modal', ['item' => $item])
        @endcan
        @can('update_materials')
            @include('dashboard.materials.edit-modal', ['item' => $item])
        @endcan
    @endforeach
@endpush

@if(isset($lectuers) && $lectuers->count() > 0)
@push('scripts')
<script>
function filterMaterials() {
    var el = document.getElementById('filter_lecture_id');
    if (!el) return;
    var lectureId = el.value;
    var url = new URL(window.location.href);
    if (lectureId) url.searchParams.set('lecture_id', lectureId);
    else url.searchParams.delete('lecture_id');
    window.location.href = url.toString();
}
</script>
@endpush
@endif

@if(isset($stages) && $stages->count() > 0)
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
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