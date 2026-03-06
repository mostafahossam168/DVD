@extends('dashboard.layouts.backend', ['title' => 'المواد الدراسية'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">المواد الدراسية</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>المواد الدراسية</h1>
        <div class="page-header-actions">
            @can('create_subjects')
                <button type="button" class="btn-add-ds" data-bs-toggle="modal" data-bs-target="#create">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </button>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.subjects.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.subjects.index', array_filter(['status' => 'yes', 'stage_id' => request('stage_id'), 'grade_id' => request('grade_id')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.subjects.index', array_filter(['status' => 'no', 'stage_id' => request('stage_id'), 'grade_id' => request('grade_id')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            <select id="filter_stage_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px;margin-inline-start:10px" onchange="filterSubjects()">
                <option value="">جميع المراحل</option>
                @foreach($stages as $stage)
                    <option value="{{ $stage->id }}" @selected(request('stage_id') == $stage->id)>{{ $stage->name }}</option>
                @endforeach
            </select>
            <select id="filter_grade_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px;margin-inline-start:6px" onchange="filterSubjects()">
                <option value="">جميع الصفوف</option>
                @foreach($grades as $grade)
                    @if(!request('stage_id') || $grade->stage_id == request('stage_id'))
                        <option value="{{ $grade->id }}" @selected(request('grade_id') == $grade->id)>{{ $grade->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.subjects.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('stage_id'))<input type="hidden" name="stage_id" value="{{ request('stage_id') }}">@endif
                @if(request('grade_id'))<input type="hidden" name="grade_id" value="{{ request('grade_id') }}">@endif
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
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>الصف الدراسي</th>
                    <th>المرحلة الدراسية</th>
                    <th>المعلمين</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td class="td-avatar-ds">
                            @if($item->image && file_exists(public_path('uploads/' . $item->image)))
                                <img src="{{ display_file($item->image) }}" alt="" class="row-avatar-ds">
                            @else
                                <div class="row-avatar-ph-ds">{{ mb_substr($item->name ?? '—', 0, 1) }}</div>
                            @endif
                        </td>
                        <td><span style="font-weight:800">{{ $item->name }}</span></td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td style="font-size:.9rem">{{ $item->grade->name ?? '—' }}</td>
                        <td style="color:var(--muted);font-size:.9rem">{{ $item->grade->stage->name ?? '—' }}</td>
                        <td>
                            <a href="{{ route('dashboard.teachers.index', ['subject_id' => $item->id]) }}" class="count-badge-ds {{ $item->teachers()->count() > 0 ? 'high-ds' : 'zero-ds' }}">{{ $item->teachers()->count() }}</a>
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_subjects')
                                    <button type="button" class="action-btn-ds edit-ds" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                @endcan
                                @can('delete_subjects')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد مواد</td>
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
    @can('create_subjects')
        @include('dashboard.subjects.create-modal')
    @endcan
    @foreach($items as $item)
        @can('delete_subjects')
            @include('dashboard.subjects.delete-modal', ['item' => $item])
        @endcan
        @can('update_subjects')
            @include('dashboard.subjects.edit-modal', ['item' => $item])
        @endcan
    @endforeach
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function filterSubjects() {
                const stageId = document.getElementById('filter_stage_id').value;
                const gradeId = document.getElementById('filter_grade_id').value;
                const url = new URL(window.location.href);
                if (stageId) url.searchParams.set('stage_id', stageId);
                else url.searchParams.delete('stage_id');
                if (gradeId) url.searchParams.set('grade_id', gradeId);
                else url.searchParams.delete('grade_id');
                if (url.searchParams.get('status')) { /* keep status */ }
                window.location.href = url.toString();
            }
            $('#filter_stage_id').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#filter_grade_id');
                if (stage_id) {
                    var url = "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stage_id);
                    $.ajax({ url: url, type: "GET", dataType: "json", success: function(data) {
                        gradeSelect.empty().append("<option value=''>جميع الصفوف</option>");
                        $.each(data, function(key, value) { gradeSelect.append('<option value="' + value + '">' + key + '</option>'); });
                        filterSubjects();
                    }});
                } else {
                    gradeSelect.empty().append("<option value=''>جميع الصفوف</option>");
                    @foreach($grades as $grade)
                    gradeSelect.append('<option value="{{ $grade->id }}">{{ $grade->name }}</option>');
                    @endforeach
                    filterSubjects();
                }
            });
            $('#create select[name="stage_id"]').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#create select[name="grade_id"]');
                if (stage_id) {
                    $.ajax({ url: "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stage_id), type: "GET", dataType: "json", success: function(data) {
                        gradeSelect.empty().append("<option selected disabled>-- اختر --</option>");
                        $.each(data, function(key, value) { gradeSelect.append('<option value="' + value + '">' + key + '</option>'); });
                    }});
                } else {
                    gradeSelect.empty().append("<option selected disabled>-- اختر المرحلة أولاً --</option>");
                }
            });
            @foreach($items as $item)
            $('#edit{{ $item->id }} select[name="stage_id"]').on('change', function() {
                var stage_id = $(this).val();
                var gradeSelect = $('#edit{{ $item->id }} select[name="grade_id"]');
                var currentGradeId = {{ $item->grade_id }};
                if (stage_id) {
                    $.ajax({ url: "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stage_id), type: "GET", dataType: "json", success: function(data) {
                        gradeSelect.empty().append("<option selected disabled>-- اختر --</option>");
                        $.each(data, function(key, value) {
                            gradeSelect.append('<option value="' + value + '" ' + (value == currentGradeId ? 'selected' : '') + '>' + key + '</option>');
                        });
                    }});
                } else {
                    gradeSelect.empty().append("<option selected disabled>-- اختر المرحلة أولاً --</option>");
                }
            });
            @endforeach
        });
        function filterSubjects() {
            var stageId = document.getElementById('filter_stage_id') && document.getElementById('filter_stage_id').value;
            var gradeId = document.getElementById('filter_grade_id') && document.getElementById('filter_grade_id').value;
            var url = new URL(window.location.href);
            if (stageId) url.searchParams.set('stage_id', stageId); else url.searchParams.delete('stage_id');
            if (gradeId) url.searchParams.set('grade_id', gradeId); else url.searchParams.delete('grade_id');
            window.location.href = url.toString();
        }
    </script>
@endpush