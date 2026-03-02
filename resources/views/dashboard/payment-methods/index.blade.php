@extends('dashboard.layouts.backend', ['title' => 'طرق الدفع'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">طرق الدفع</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center gap-2 mt-2">
                @can('create_payment_methods')
                    <a href="{{ route('dashboard.payment-methods.create') }}" class="main-btn"><i class="fas fa-plus"></i> إضافة</a>
                @endcan
                <span class="main-btn btn-main-color">الكل: {{ $items->total() }}</span>
                <span class="main-btn btn-sm bg-success">مفعلة: {{ $count_active }}</span>
                <span class="main-btn btn-sm bg-danger">غير مفعلة: {{ $count_inactive }}</span>
            </div>
        </div>

        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
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
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td>{{ $item->name }}</td>
                            <td><strong>{{ $item->code }}</strong></td>
                            <td>
                                @if ($item->is_active)
                                    <span class="badge bg-success">مفعلة</span>
                                @else
                                    <span class="badge bg-danger">غير مفعلة</span>
                                @endif
                            </td>
                            <td>
                                @can('update_payment_methods')
                                    <a href="{{ route('dashboard.payment-methods.edit', $item) }}" class="btn btn-primary btn-sm text-white">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">لا توجد طرق دفع.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>
@endsection
