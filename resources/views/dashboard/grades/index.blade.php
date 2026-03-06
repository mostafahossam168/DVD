@extends('dashboard.layouts.backend', ['title' => 'الصفوف الدراسية'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الصفوف الدراسية</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الصفوف الدراسية</h1>
        <div class="page-header-actions">
            @can('create_grades')
                <button type="button" class="btn-add-ds" data-bs-toggle="modal" data-bs-target="#create">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </button>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.grades.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.grades.index', array_filter(['status' => 'yes', 'stage_id' => request('stage_id')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.grades.index', array_filter(['status' => 'no', 'stage_id' => request('stage_id')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            <form action="{{ route('dashboard.grades.index') }}" method="get" class="filter-grade-stage-ds" style="display:inline-flex;align-items:center;gap:8px;margin-inline-start:10px">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <select name="stage_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" onchange="this.form.submit()">
                    <option value="">جميع المراحل</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(request('stage_id') == $stage->id)>{{ $stage->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.grades.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('stage_id'))<input type="hidden" name="stage_id" value="{{ request('stage_id') }}">@endif
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
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>المرحلة الدراسية</th>
                    <th>المواد الدراسية</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->name }}</span></td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td style="color:var(--muted);font-size:.9rem">{{ $item->stage->name ?? '—' }}</td>
                        <td>
                            <a href="{{ route('dashboard.subjects.index', ['garde_id' => $item->id]) }}" class="count-badge-ds {{ $item->subjects->count() > 0 ? 'high-ds' : 'zero-ds' }}">{{ $item->subjects->count() }}</a>
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_grades')
                                    <button type="button" class="action-btn-ds edit-ds" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                @endcan
                                @can('delete_grades')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد صفوف</td>
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
    @can('create_grades')
        @include('dashboard.grades.create-modal')
    @endcan
    @foreach($items as $item)
        @can('delete_grades')
            @include('dashboard.grades.delete-modal', ['item' => $item])
        @endcan
        @can('update_grades')
            @include('dashboard.grades.edit-modal', ['item' => $item])
        @endcan
    @endforeach
@endpush