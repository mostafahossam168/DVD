@extends('dashboard.layouts.backend', ['title' => 'المصروفات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">المصروفات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>المصروفات</h1>
    </div>

    <x-alert-component></x-alert-component>

    <div class="fade-up-ds delay-1-ds" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:12px">
        @foreach($walletCards as $card)
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:14px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                    <div style="font-weight:800;color:#0f172a">{{ $card['name'] }}</div>
                    <div style="width:34px;height:34px;border-radius:10px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center">💸</div>
                </div>
                <div style="margin-top:8px;font-size:1.15rem;font-weight:900;color:#0f172a">{{ number_format($card['total'], 2) }} ج.م</div>
            </div>
        @endforeach
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:14px;padding:14px">
            <div style="font-size:.82rem;color:#991b1b">إجمالي المصروفات</div>
            <div style="margin-top:6px;font-size:1.2rem;font-weight:900;color:#dc2626">{{ number_format($totalExpenses, 2) }} ج.م</div>
        </div>
    </div>

    <div class="form-card-ds fade-up-ds delay-1-ds" style="margin-bottom:12px">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#fee2e2">🧾</div>
            <div>
                <h2>تسجيل مصروف جديد</h2>
                <p>إضافة مصروف على خزنة إنستا باي أو فودافون كاش.</p>
            </div>
        </div>
        <form action="{{ route('dashboard.expenses.store') }}" method="POST">
            @csrf
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">الخزنة <span class="required-ds">*</span></label>
                        <select name="payment_method_id" class="form-control-ds" required>
                            <option value="">اختر الخزنة</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المبلغ <span class="required-ds">*</span></label>
                        <input type="number" step="0.01" min="0.01" name="amount" class="form-control-ds" placeholder="0.00" required>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الفئة <span class="required-ds">*</span></label>
                        <input type="text" name="category" class="form-control-ds" placeholder="مثال: دعاية / أدوات / تشغيل" required>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">التاريخ <span class="required-ds">*</span></label>
                        <input type="date" name="expense_date" class="form-control-ds" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group-ds" style="grid-column:1/-1">
                        <label class="form-label-ds">الوصف</label>
                        <input type="text" name="description" class="form-control-ds" placeholder="وصف المصروف (اختياري)">
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">تسجيل المصروف</button>
            </div>
        </form>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-2-ds" style="margin-bottom:12px">
        <div class="filters-right-ds">
            <select id="filter_wallet" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:160px" onchange="filterExpenses()">
                <option value="">كل الخزن</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}" @selected(request('payment_method_id') == $wallet->id)>{{ $wallet->name }}</option>
                @endforeach
            </select>
            <input type="text" id="filter_category" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:160px" value="{{ request('category') }}" placeholder="الفئة">
            <input type="date" id="filter_from_date" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" value="{{ request('from_date') }}">
            <input type="date" id="filter_to_date" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" value="{{ request('to_date') }}">
            <button type="button" class="btn-ds btn-primary-ds" style="height:36px;padding:0 16px" onclick="filterExpenses()">تطبيق</button>
            <a href="{{ route('dashboard.expenses.index') }}" class="filter-badge-ds" style="text-decoration:none">إعادة ضبط</a>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.expenses.index') }}" method="GET" class="search-wrap-ds">
                @if(request('payment_method_id'))<input type="hidden" name="payment_method_id" value="{{ request('payment_method_id') }}">@endif
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('from_date'))<input type="hidden" name="from_date" value="{{ request('from_date') }}">@endif
                @if(request('to_date'))<input type="hidden" name="to_date" value="{{ request('to_date') }}">@endif
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث...">
            </form>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>الفئة</th>
                    <th>الوصف</th>
                    <th>الخزنة</th>
                    <th>المبلغ</th>
                    <th>بواسطة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td>{{ $item->expense_date?->format('Y-m-d') }}</td>
                        <td><span class="assessment-type-chip" style="background:#eef2ff;color:#3730a3">{{ $item->category ?: '—' }}</span></td>
                        <td>{{ $item->description ?: '—' }}</td>
                        <td>{{ $item->paymentMethod?->name ?? '—' }}</td>
                        <td style="font-weight:800;color:#b91c1c">- {{ number_format((float) $item->amount, 2) }} ج.م</td>
                        <td>{{ $item->creator?->full_name ?? $item->creator?->fullname ?? '—' }}</td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('delete_subscriptions')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#deleteExpense{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد مصروفات</td>
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
        @can('delete_subscriptions')
            @include('dashboard.expenses.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush

@push('scripts')
<script>
    function filterExpenses() {
        var wallet = document.getElementById('filter_wallet') ? document.getElementById('filter_wallet').value : '';
        var category = document.getElementById('filter_category') ? document.getElementById('filter_category').value : '';
        var fromDate = document.getElementById('filter_from_date') ? document.getElementById('filter_from_date').value : '';
        var toDate = document.getElementById('filter_to_date') ? document.getElementById('filter_to_date').value : '';
        var url = new URL(window.location.href);
        if (wallet) url.searchParams.set('payment_method_id', wallet); else url.searchParams.delete('payment_method_id');
        if (category) url.searchParams.set('category', category); else url.searchParams.delete('category');
        if (fromDate) url.searchParams.set('from_date', fromDate); else url.searchParams.delete('from_date');
        if (toDate) url.searchParams.set('to_date', toDate); else url.searchParams.delete('to_date');
        window.location.href = url.toString();
    }
</script>
@endpush

