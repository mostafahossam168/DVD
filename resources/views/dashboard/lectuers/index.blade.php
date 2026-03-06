@extends('dashboard.layouts.backend', ['title' => 'الدروس'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الدروس</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الدروس</h1>
        <div class="page-header-actions">
            @can('create_lectuers')
                <a href="{{ route('dashboard.lectuers.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.lectuers.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.lectuers.index', array_filter(['status' => 'yes', 'subject_id' => request('subject_id')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعلين <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.lectuers.index', array_filter(['status' => 'no', 'subject_id' => request('subject_id')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعلين <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            @if(isset($subjects) && $subjects->count() > 0)
                <select id="filter_subject_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:160px;margin-inline-start:10px" onchange="filterLectures()">
                    <option value="">جميع المواد</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected(request('subject_id') == $subject->id)>{{ $subject->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.lectuers.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('subject_id'))<input type="hidden" name="subject_id" value="{{ request('subject_id') }}">@endif
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
                    <th>المرحلة</th>
                    <th>الصف</th>
                    <th>المادة</th>
                    <th>الوصف</th>
                    <th>الرابط</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->title }}</span></td>
                        <td style="font-size:.85rem">{{ $item->subject->grade->stage->name ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ $item->subject->grade->name ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ $item->subject->name ?? '—' }}</td>
                        <td>
                            <button type="button" class="action-btn-ds edit-ds" data-bs-toggle="modal" data-bs-target="#showDes{{ $item->id }}" title="عرض الوصف">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                        <td>
                            @if($item->link)
                                <a target="_blank" href="{{ $item->link }}" class="action-btn-ds edit-ds" title="فتح الرابط">🔗</a>
                            @else
                                —
                            @endif
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
                                @can('update_lectuers')
                                    <a href="{{ route('dashboard.lectuers.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endcan
                                @can('delete_lectuers')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد دروس</td>
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
    @foreach($items as $item)
        @include('dashboard.lectuers.show-description-model', ['item' => $item])
        @can('delete_lectuers')
            @include('dashboard.lectuers.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush

@if(isset($subjects) && $subjects->count() > 0)
@push('scripts')
<script>
function filterLectures() {
    var el = document.getElementById('filter_subject_id');
    if (!el) return;
    var subjectId = el.value;
    var url = new URL(window.location.href);
    if (subjectId) url.searchParams.set('subject_id', subjectId);
    else url.searchParams.delete('subject_id');
    window.location.href = url.toString();
}
</script>
@endpush
@endif