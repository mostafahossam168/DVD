@extends('dashboard.layouts.backend', ['title' => 'التقييمات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">التقييمات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>التقييمات</h1>
        <div class="page-header-actions">
            @can('create_assessments')
                <a href="{{ route('dashboard.assessments.create') }}" class="btn-add-ds">إضافة تقييم</a>
            @endcan
        </div>
    </div>

    <x-alert-component></x-alert-component>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.assessments.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.assessments.index', array_filter(['status' => 'yes', 'type' => request('type')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.assessments.index', array_filter(['status' => 'no', 'type' => request('type')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            <form action="{{ route('dashboard.assessments.index') }}" method="GET" style="display:inline-flex;align-items:center;gap:8px;margin-inline-start:10px">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <select name="type" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" onchange="this.form.submit()">
                    <option value="">النوع</option>
                    <option value="exam" @selected(request('type') == 'exam')>exam</option>
                    <option value="quiz" @selected(request('type') == 'quiz')>quiz</option>
                    <option value="assignment" @selected(request('type') == 'assignment')>assignment</option>
                </select>
            </form>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.assessments.index') }}" method="GET" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
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
                    <th>النوع</th>
                    <th>عدد الأسئلة</th>
                    <th>المدة</th>
                    <th>الفترة</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="td-num-ds">{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->stage?->name ?? '—' }}</td>
                    <td>{{ $item->grade?->name ?? '—' }}</td>
                    <td>{{ $item->subject?->name ?? '—' }}</td>
                    <td>{{ $item->type }}</td>
                    <td><span class="count-badge-ds high-ds">{{ $item->questions->count() }}</span></td>
                    <td>{{ $item->duration ?? '—' }} د</td>
                    <td style="font-size:.85rem">{{ $item->start_time?->format('Y-m-d H:i') ?? '—' }}<br>{{ $item->end_time?->format('Y-m-d H:i') ?? '—' }}</td>
                    <td>
                        @if($item->status)
                        <span class="status-badge-ds enabled-ds">مفعل</span>
                        @else
                        <span class="status-badge-ds disabled-ds">غير مفعل</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions-cell-ds">
                            <a href="{{ route('dashboard.assessments.show', $item->id) }}" class="action-btn-ds" title="عرض">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @can('update_assessments')
                            <a href="{{ route('dashboard.assessments.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endcan
                            @can('delete_assessments')
                            <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" style="text-align:center;padding:2rem">لا توجد تقييمات</td></tr>
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
        @can('delete_assessments')
            @include('dashboard.assessments.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush
