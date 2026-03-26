@extends('dashboard.layouts.backend', ['title' => 'المدفوعات'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">المدفوعات</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>المدفوعات</h1>
    </div>

    <x-alert-component></x-alert-component>

    <div class="fade-up-ds delay-1-ds" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:12px">
        @foreach($walletCards as $card)
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:14px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                    <div style="font-weight:800;color:#0f172a">{{ $card['name'] }}</div>
                    <div style="width:34px;height:34px;border-radius:10px;background:#eaf2ff;color:#2563eb;display:flex;align-items:center;justify-content:center">💳</div>
                </div>
                <div style="font-size:.78rem;color:#64748b;min-height:34px">
                    @if($card['numbers']->count())
                        {{ $card['numbers']->implode(' - ') }}
                    @else
                        لا توجد أرقام مضافة
                    @endif
                </div>
                <div style="margin-top:8px;font-size:1.15rem;font-weight:900;color:#0f172a">
                    {{ number_format($card['paid_amount'], 2) }} ج.م
                </div>
            </div>
        @endforeach
        <div style="background:#ecfdf5;border:1px solid #bbf7d0;border-radius:14px;padding:14px">
            <div style="font-size:.82rem;color:#065f46">إجمالي المدفوع</div>
            <div style="margin-top:6px;font-size:1.2rem;font-weight:900;color:#047857">{{ number_format($paidAmount, 2) }} ج.م</div>
        </div>
        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:14px;padding:14px">
            <div style="font-size:.82rem;color:#9a3412">إجمالي المعلق</div>
            <div style="margin-top:6px;font-size:1.2rem;font-weight:900;color:#c2410c">{{ number_format($pendingAmount, 2) }} ج.م</div>
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds" style="margin-bottom:12px">
        <div class="filters-right-ds">
            <select id="filter_method" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" onchange="filterPayments()">
                <option value="">كل طرق الدفع</option>
                <option value="vodafone_cash" @selected(request('method') === 'vodafone_cash')>فودافون كاش</option>
                <option value="instapay" @selected(request('method') === 'instapay')>انستاباي</option>
            </select>
            <select id="filter_payment_status" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" onchange="filterPayments()">
                <option value="">كل الحالات</option>
                <option value="paid" @selected(request('payment_status') === 'paid')>مدفوع</option>
                <option value="pending" @selected(request('payment_status') === 'pending')>معلق</option>
                <option value="rejected" @selected(request('payment_status') === 'rejected')>مرفوض</option>
            </select>
            <input type="date" id="filter_from_date" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" value="{{ request('from_date') }}" onchange="filterPayments()">
            <input type="date" id="filter_to_date" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:140px" value="{{ request('to_date') }}" onchange="filterPayments()">
            <a href="{{ route('dashboard.payments.index') }}" class="filter-badge-ds" style="text-decoration:none">إعادة ضبط</a>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.payments.index') }}" method="get" class="search-wrap-ds">
                @if(request('method'))<input type="hidden" name="method" value="{{ request('method') }}">@endif
                @if(request('payment_status'))<input type="hidden" name="payment_status" value="{{ request('payment_status') }}">@endif
                @if(request('from_date'))<input type="hidden" name="from_date" value="{{ request('from_date') }}">@endif
                @if(request('to_date'))<input type="hidden" name="to_date" value="{{ request('to_date') }}">@endif
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث بالطالب/المادة/رقم التحويل...">
            </form>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>المادة</th>
                    <th>طريقة الدفع</th>
                    <th>الهاتف/المرجع</th>
                    <th>إثبات الدفع</th>
                    <th>المبلغ</th>
                    <th>حالة الدفع</th>
                    <th>التاريخ</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                        <td>{{ $payment->user?->full_name ?? $payment->user?->fullname ?? '—' }}</td>
                        <td>{{ $payment->subject?->name ?? '—' }}</td>
                        <td>{{ $payment->payment_method ?? '—' }}</td>
                        <td style="font-size:.85rem">
                            {{ $payment->payment_phone ?: '—' }}
                            @if($payment->payment_reference)
                                <br><small>مرجع: {{ $payment->payment_reference }}</small>
                            @endif
                        </td>
                        <td>
                            @if($payment->payment_screenshot)
                                <a href="{{ display_file($payment->payment_screenshot) }}" target="_blank" rel="noopener" class="action-btn-ds edit-ds">عرض</a>
                            @else
                                —
                            @endif
                        </td>
                        <td style="font-weight:800">{{ number_format((float) ($payment->amount_paid ?? $payment->subject?->price ?? 0), 2) }}</td>
                        <td>
                            @if($payment->payment_status === 'paid')
                                <span class="status-badge-ds enabled-ds">مدفوع</span>
                            @elseif($payment->payment_status === 'rejected')
                                <span class="status-badge-ds disabled-ds" style="background:#fef2f2;color:#dc2626">مرفوض</span>
                            @else
                                <span class="status-badge-ds" style="background:#fff7ed;color:#c2410c">معلق</span>
                            @endif
                        </td>
                        <td style="font-size:.85rem">{{ $payment->created_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            <div class="actions-cell-ds">
                                @if($payment->payment_status === 'pending')
                                    @can('update_subscriptions')
                                        <form action="{{ route('dashboard.subscriptions.approve', $payment) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            <button type="submit" class="action-btn-ds" style="background:#ecfdf5;color:#047857;border-color:#bbf7d0" title="تأكيد الدفع">✓</button>
                                        </form>
                                        <form action="{{ route('dashboard.subscriptions.reject', $payment) }}" method="POST" style="display:inline-block" onsubmit="return confirm('تأكيد رفض الدفع؟')">
                                            @csrf
                                            <button type="submit" class="action-btn-ds" style="background:#fef2f2;color:#dc2626;border-color:#fecaca" title="رفض الدفع">✕</button>
                                        </form>
                                    @endcan
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد مدفوعات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($payments->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">{{ $payments->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterPayments() {
        var method = document.getElementById('filter_method') ? document.getElementById('filter_method').value : '';
        var paymentStatus = document.getElementById('filter_payment_status') ? document.getElementById('filter_payment_status').value : '';
        var fromDate = document.getElementById('filter_from_date') ? document.getElementById('filter_from_date').value : '';
        var toDate = document.getElementById('filter_to_date') ? document.getElementById('filter_to_date').value : '';
        var url = new URL(window.location.href);
        if (method) url.searchParams.set('method', method); else url.searchParams.delete('method');
        if (paymentStatus) url.searchParams.set('payment_status', paymentStatus); else url.searchParams.delete('payment_status');
        if (fromDate) url.searchParams.set('from_date', fromDate); else url.searchParams.delete('from_date');
        if (toDate) url.searchParams.set('to_date', toDate); else url.searchParams.delete('to_date');
        window.location.href = url.toString();
    }
</script>
@endpush

