@extends('dashboard.layouts.backend', ['title' => 'الكوبونات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الكوبونات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_coupons')
                        <a href="{{ route('dashboard.coupons.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.coupons.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.coupons.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ $count_active }}</a>
                    <a href="{{ route('dashboard.coupons.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين :{{ $count_inactive }}</a>
                </div>
            </div>
            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon" />
                    <input type="search" id="" value="{{ request('search') }}" name="search"
                        placeholder="@lang('Search')" />
                </form>
            </div>
        </div>
        
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-3">
                <select name="type" class="form-select" onchange="filterCoupons()">
                    <option value="">جميع الأنواع</option>
                    <option value="percentage" @selected(request('type') == 'percentage')>نسبة مئوية</option>
                    <option value="fixed" @selected(request('type') == 'fixed')>مبلغ ثابت</option>
                </select>
            </div>
        </div>
        
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>قيمة الخصم</th>
                        <th>الحد الأدنى</th>
                        <th>حد الاستخدام</th>
                        <th>عدد الاستخدام</th>
                        <th>تاريخ البداية</th>
                        <th>تاريخ النهاية</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->code }}</strong></td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if($item->type == 'percentage')
                                    <span class="badge bg-info">نسبة مئوية</span>
                                @else
                                    <span class="badge bg-warning">مبلغ ثابت</span>
                                @endif
                            </td>
                            <td>
                                @if($item->type == 'percentage')
                                    {{ $item->value }}%
                                @else
                                    {{ number_format($item->value, 2) }} ر.س
                                @endif
                            </td>
                            <td>
                                @if($item->min_amount)
                                    {{ number_format($item->min_amount, 2) }} ر.س
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->usage_limit)
                                    {{ $item->usage_limit }}
                                @else
                                    <span class="text-muted">غير محدود</span>
                                @endif
                            </td>
                            <td>{{ $item->used_count }}</td>
                            <td>
                                @if($item->start_date)
                                    {{ $item->start_date->format('Y-m-d') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->end_date)
                                    {{ $item->end_date->format('Y-m-d') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_coupons')
                                        <a href="{{ route('dashboard.coupons.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_coupons')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.coupons.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>
    
    <script>
        function filterCoupons() {
            const type = document.querySelector('select[name="type"]').value;
            const url = new URL(window.location.href);
            
            if (type) {
                url.searchParams.set('type', type);
            } else {
                url.searchParams.delete('type');
            }
            
            window.location.href = url.toString();
        }
    </script>
@endsection
