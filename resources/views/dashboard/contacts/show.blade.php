@extends('dashboard.layouts.backend', ['title' => 'عرض رسالة تواصل'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.contacts.index') }}">رسائل تواصل معنا</a>
        <span class="sep">/</span>
        <span class="current">عرض رسالة</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>عرض رسالة</h1>
        <div class="page-header-actions">
            <a href="{{ route('dashboard.contacts.index') }}" class="btn-back-ds" style="margin-bottom:0">رجوع</a>
        </div>
    </div>
    <x-alert-component></x-alert-component>
    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#eff6ff">✉️</div>
            <div>
                <h2>بيانات المرسل</h2>
                <p>تفاصيل رسالة تواصل معنا.</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-grid-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds">الاسم</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $contact->name }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الهاتف</label>
                    <div class="form-control-ds" style="background:#f9fafb;direction:ltr;text-align:right">{{ $contact->phone }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">البريد الإلكتروني</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $contact->email }}</div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">تاريخ الإرسال</label>
                    <div class="form-control-ds" style="background:#f9fafb">{{ $contact->created_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
            <div class="form-divider-ds">الرسالة</div>
            <div class="form-group-ds" style="grid-column:1 / -1">
                <div class="form-control-ds" style="background:#f9fafb;min-height:120px;white-space:pre-wrap">{{ $contact->message }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
