@extends('dashboard.layouts.backend', ['title' => 'الطلاب'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الطلاب</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الطلاب</h1>
        <div class="page-header-actions">
            @can('create_students')
                <a href="{{ route('dashboard.students.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.students.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.students.index', ['status' => 'yes']) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعلين <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.students.index', ['status' => 'no']) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعلين <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.students.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث...">
            </form>
        </div>
    </div>

    <x-alert-component></x-alert-component>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الهاتف</th>
                    <th>الحالة</th>
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
                                <div class="row-avatar-ph-ds">{{ mb_substr($item->full_name ?? $item->email ?? '—', 0, 1) }}</div>
                            @endif
                        </td>
                        <td><span style="font-weight:800">{{ $item->full_name ?? '—' }}</span></td>
                        <td style="color:var(--muted);font-size:.83rem">{{ $item->email ?? '—' }}</td>
                        <td style="font-size:.83rem;direction:ltr;text-align:right">{{ $item->phone ?? '—' }}</td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_students')
                                    <a href="{{ route('dashboard.students.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endcan
                                @can('delete_students')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا يوجد طلاب</td>
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
        @can('delete_students')
            @include('dashboard.students.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush
