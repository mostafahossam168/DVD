@extends('dashboard.layouts.backend', ['title' => 'عرض معلم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.teachers.index') }}">المعلمين</a>
        <span class="sep">/</span>
        <span class="current">عرض معلم</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>عرض المعلم</h1>
        <div class="page-header-actions">
            <a href="{{ route('dashboard.teachers.index') }}" class="btn-back-ds" style="margin-bottom:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                رجوع
            </a>
        </div>
    </div>

    <x-alert-component></x-alert-component>

    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#fef3c7">
                @if($item->image && file_exists(public_path('uploads/' . $item->image)))
                    <img src="{{ display_file($item->image) }}" alt="" style="width:40px;height:40px;border-radius:12px;object-fit:cover;border:2px solid #fbbf24">
                @else
                    <span>{{ mb_substr($item->fullname ?? $item->email ?? 'م', 0, 1) }}</span>
                @endif
            </div>
            <div>
                <h2>{{ $item->fullname }}</h2>
                <p>عرض بيانات المعلم وصلاحيته في النظام.</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-grid-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds">الاسم الأول</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $item->f_name }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الاسم الأخير</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $item->l_name }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">البريد الإلكتروني</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $item->email }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الهاتف</label>
                    <div class="form-control-ds" style="background:#f9fafb;direction:ltr;text-align:right">{{ $item->phone }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الحالة</label>
                    <div>
                        @if($item->status)
                            <span class="status-badge-ds enabled-ds">مفعل</span>
                        @else
                            <span class="status-badge-ds disabled-ds">غير مفعل</span>
                        @endif
                    </div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الصلاحية</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $item->roles->first()?->name ?? '—' }}</div>
                </div>
            </div>

            <div class="form-divider-ds">نبذة عن المعلم</div>
            <div class="form-group-ds" style="grid-column:1 / -1">
                <div class="form-control-ds" style="background:#f9fafb;min-height:90px;white-space:pre-wrap">
                    {{ $item->more_information ?: 'لا توجد نبذة مضافة.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
