@extends('dashboard.layouts.backend', ['title' => 'طرق الدفع'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">طرق الدفع</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>طرق الدفع</h1>
        <div class="page-header-actions">
            @can('create_payment_methods')
                <a href="{{ route('dashboard.payment-methods.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <span class="filter-badge-ds active-ds">الكل <span class="badge-count-ds">{{ $items->total() }}</span></span>
            <span class="filter-badge-ds enabled-ds">مفعلة <span class="badge-count-ds">{{ $count_active }}</span></span>
            <span class="filter-badge-ds disabled-ds">غير مفعلة <span class="badge-count-ds">{{ $count_inactive }}</span></span>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الكود</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td><span style="font-weight:800">{{ $item->name }}</span></td>
                        <td><strong>{{ $item->code }}</strong></td>
                        <td>
                            @if($item->is_active)
                                <span class="status-badge-ds enabled-ds">مفعلة</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعلة</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_payment_methods')
                                    <a href="{{ route('dashboard.payment-methods.edit', $item) }}" class="action-btn-ds edit-ds" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد طرق دفع</td>
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
