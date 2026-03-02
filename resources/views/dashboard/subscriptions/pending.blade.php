@extends('dashboard.layouts.backend', ['title' => 'طلبات الاشتراك المعلقة'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="small">اشتراكات الطلاب</div>/
            <div class="large">طلبات الاشتراك المعلقة</div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('dashboard.subscriptions.index') }}" class="main-btn btn-main-color fs-13px">
                <i class="fa-solid fa-arrow-left fs-13px"></i> كل الاشتراكات
            </a>
        </div>

        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>المادة</th>
                        <th>طريقة الدفع</th>
                        <th>رقم الهاتف / المرجع</th>
                        <th>صورة التحويل</th>
                        <th>التاريخ</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td>
                                {{ $item->user->f_name ?? '' }} {{ $item->user->l_name ?? '' }}
                                @if($item->user->email)
                                    <br><small class="text-muted">{{ $item->user->email }}</small>
                                @endif
                            </td>
                            <td>{{ $item->subject->name ?? '-' }}</td>
                            <td>{{ $item->payment_method ?? '-' }}</td>
                            <td>
                                @if($item->payment_phone)
                                    <span>{{ $item->payment_phone }}</span>
                                @endif
                                @if($item->payment_reference)
                                    <br><small>مرجع: {{ $item->payment_reference }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->payment_screenshot)
                                    <a href="{{ display_file($item->payment_screenshot) }}" target="_blank" rel="noopener">
                                        <img src="{{ display_file($item->payment_screenshot) }}" alt="تحويل" style="max-width:80px;max-height:60px;object-fit:cover;">
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @can('update_subscriptions')
                                    <form action="{{ route('dashboard.subscriptions.approve', $item) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">موافقة</button>
                                    </form>
                                    <form action="{{ route('dashboard.subscriptions.reject', $item) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">رفض</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">لا توجد طلبات اشتراك معلقة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>
@endsection
