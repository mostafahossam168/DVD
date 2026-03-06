@extends('dashboard.layouts.backend', ['title' => 'طلبات الاشتراك المعلقة'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.subscriptions.index') }}">الاشتراكات</a>
        <span class="sep">/</span>
        <span class="current">طلبات الاشتراك المعلقة</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>طلبات الاشتراك المعلقة</h1>
        <div class="page-header-actions">
            <a href="{{ route('dashboard.subscriptions.index') }}" class="btn-back-ds" style="margin-bottom:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                كل الاشتراكات
            </a>
        </div>
    </div>

    <x-alert-component></x-alert-component>

    <div class="table-wrap-ds fade-up-ds delay-1-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطالب</th>
                    <th>المادة</th>
                    <th>طريقة الدفع</th>
                    <th>الهاتف / المرجع</th>
                    <th>صورة التحويل</th>
                    <th>التاريخ</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td>
                            <span style="font-weight:800">{{ $item->user->f_name ?? '' }} {{ $item->user->l_name ?? '' }}</span>
                            @if($item->user->email)
                                <br><small style="color:var(--muted);font-size:.8rem">{{ $item->user->email }}</small>
                            @endif
                        </td>
                        <td style="font-size:.9rem">{{ $item->subject->name ?? '—' }}</td>
                        <td style="font-size:.9rem">{{ $item->payment_method ?? '—' }}</td>
                        <td style="font-size:.85rem">
                            @if($item->payment_phone) {{ $item->payment_phone }} @endif
                            @if($item->payment_reference) <br><small>مرجع: {{ $item->payment_reference }}</small> @endif
                            @if(!$item->payment_phone && !$item->payment_reference) — @endif
                        </td>
                        <td>
                            @if($item->payment_screenshot)
                                <a href="{{ display_file($item->payment_screenshot) }}" target="_blank" rel="noopener" class="action-btn-ds edit-ds" title="عرض">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            @else — @endif
                        </td>
                        <td style="font-size:.85rem">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_subscriptions')
                                    <form action="{{ route('dashboard.subscriptions.approve', $item) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-ds btn-success-ds" style="padding:6px 14px;font-size:.8rem">موافقة</button>
                                    </form>
                                    <form action="{{ route('dashboard.subscriptions.reject', $item) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-ds btn-secondary-ds" style="padding:6px 14px;font-size:.8rem;background:#fef2f2;color:#dc2626;border-color:#fecaca">رفض</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد طلبات اشتراك معلقة</td>
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
