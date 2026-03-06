@extends('dashboard.layouts.backend', ['title' => 'الكوبونات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الكوبونات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الكوبونات</h1>
        <div class="page-header-actions">
            @can('create_coupons')
                <a href="{{ route('dashboard.coupons.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.coupons.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.coupons.index', array_filter(['status' => 'yes', 'type' => request('type')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.coupons.index', array_filter(['status' => 'no', 'type' => request('type')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            <select name="type" id="filter_coupon_type" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px;margin-inline-start:10px" onchange="filterCoupons()">
                <option value="">جميع الأنواع</option>
                <option value="percentage" @selected(request('type') == 'percentage')>نسبة مئوية</option>
                <option value="fixed" @selected(request('type') == 'fixed')>مبلغ ثابت</option>
            </select>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.coupons.index') }}" method="get" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
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
                    <th>الكود</th>
                    <th>الاسم</th>
                    <th>النوع</th>
                    <th>قيمة الخصم</th>
                    <th>الحد الأدنى</th>
                    <th>حد الاستخدام</th>
                    <th>المستخدم</th>
                    <th>البداية</th>
                    <th>النهاية</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->code }}</strong></td>
                        <td><span style="font-weight:800">{{ $item->name }}</span></td>
                        <td>
                            @if($item->type == 'percentage')
                                <span class="status-badge-ds" style="background:#eff6ff;color:var(--blue)">نسبة مئوية</span>
                            @else
                                <span class="status-badge-ds" style="background:#fef3c7;color:#d97706">مبلغ ثابت</span>
                            @endif
                        </td>
                        <td style="font-size:.9rem">
                            @if($item->type == 'percentage') {{ $item->value }}% @else {{ number_format($item->value, 2) }} ر.س @endif
                        </td>
                        <td style="font-size:.85rem;color:var(--muted)">
                            @if($item->min_amount) {{ number_format($item->min_amount, 2) }} ر.س @else — @endif
                        </td>
                        <td style="font-size:.85rem">
                            @if($item->usage_limit) {{ $item->usage_limit }} @else غير محدود @endif
                        </td>
                        <td>{{ $item->used_count }}</td>
                        <td style="font-size:.85rem">{{ $item->start_date ? $item->start_date->format('Y-m-d') : '—' }}</td>
                        <td style="font-size:.85rem">{{ $item->end_date ? $item->end_date->format('Y-m-d') : '—' }}</td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_coupons')
                                    <a href="{{ route('dashboard.coupons.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endcan
                                @can('delete_coupons')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد كوبونات</td>
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
        @can('delete_coupons')
            @include('dashboard.coupons.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush

@push('scripts')
<script>
function filterCoupons() {
    var el = document.getElementById('filter_coupon_type') || document.querySelector('select[name="type"]');
    if (!el) return;
    var type = el.value;
    var url = new URL(window.location.href);
    if (type) url.searchParams.set('type', type);
    else url.searchParams.delete('type');
    window.location.href = url.toString();
}
</script>
@endpush