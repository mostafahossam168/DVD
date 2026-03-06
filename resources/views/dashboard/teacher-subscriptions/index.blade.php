@extends('dashboard.layouts.backend', ['title' => 'اشتراكات المدرسين'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">اشتراكات المدرسين</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>اشتراكات المدرسين</h1>
        <div class="page-header-actions">
            @can('create_teacher_subscriptions')
                <a href="{{ route('dashboard.teacher-subscriptions.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.teacher-subscriptions.index', array_filter(['status' => 'yes', 'teacher_id' => request('teacher_id'), 'plan_id' => request('plan_id')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.teacher-subscriptions.index', array_filter(['status' => 'no', 'teacher_id' => request('teacher_id'), 'plan_id' => request('plan_id')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            @if(auth()->user()->hasRole('admin'))
                @if(isset($teachers) && $teachers->count() > 0)
                    <select name="teacher_id" id="filter_teacher_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:160px;margin-inline-start:10px" onchange="filterTeacherSubs()">
                        <option value="">جميع المدرسين</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(request('teacher_id') == $teacher->id)>{{ $teacher->full_name ?? $teacher->fullname ?? $teacher->email }}</option>
                        @endforeach
                    </select>
                @endif
                @if(isset($plans) && $plans->count() > 0)
                    <select name="plan_id" id="filter_plan_id" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px;margin-inline-start:6px" onchange="filterTeacherSubs()">
                        <option value="">جميع الخطط</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>{{ $plan->name }}</option>
                        @endforeach
                    </select>
                @endif
            @endif
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.teacher-subscriptions.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('teacher_id'))<input type="hidden" name="teacher_id" value="{{ request('teacher_id') }}">@endif
                @if(request('plan_id'))<input type="hidden" name="plan_id" value="{{ request('plan_id') }}">@endif
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
                    <th>المدرس</th>
                    <th>الخطة</th>
                    <th>السعر</th>
                    <th>حد المواد</th>
                    <th>حد الطلاب</th>
                    <th>الحالة</th>
                    <th>تاريخ الاشتراك</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->user->full_name ?? $item->user->fullname ?? '—' }}</span></td>
                        <td style="font-size:.9rem">{{ $item->plan->name ?? '—' }}</td>
                        <td style="font-size:.9rem">{{ number_format($item->plan->price ?? 0, 2) }} ر.س</td>
                        <td>{{ $item->plan->subjects_limit ?? '—' }}</td>
                        <td>{{ $item->plan->students_limit ?? '—' }}</td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td style="font-size:.85rem">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_teacher_subscriptions')
                                    @if(auth()->user()->hasRole('admin') || $item->user_id == auth()->id())
                                        <a href="{{ route('dashboard.teacher-subscriptions.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                    @endif
                                @endcan
                                @can('delete_teacher_subscriptions')
                                    @if(auth()->user()->hasRole('admin') || $item->user_id == auth()->id())
                                        <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد اشتراكات</td>
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
        @can('delete_teacher_subscriptions')
            @if(auth()->user()->hasRole('admin') || $item->user_id == auth()->id())
                @include('dashboard.teacher-subscriptions.delete-model', ['item' => $item])
            @endif
        @endcan
    @endforeach
@endpush

@if(auth()->user()->hasRole('admin'))
@push('scripts')
<script>
function filterTeacherSubs() {
    var teacherId = document.getElementById('filter_teacher_id') ? document.getElementById('filter_teacher_id').value : '';
    var planId = document.getElementById('filter_plan_id') ? document.getElementById('filter_plan_id').value : '';
    var url = new URL(window.location.href);
    if (teacherId) url.searchParams.set('teacher_id', teacherId); else url.searchParams.delete('teacher_id');
    if (planId) url.searchParams.set('plan_id', planId); else url.searchParams.delete('plan_id');
    window.location.href = url.toString();
}
</script>
@endpush
@endif