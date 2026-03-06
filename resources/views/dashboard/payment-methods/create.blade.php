@extends('dashboard.layouts.backend', ['title' => 'إضافة طريقة دفع'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.payment-methods.index') }}">طرق الدفع</a>
        <span class="sep">/</span>
        <span class="current">إضافة طريقة دفع</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>إضافة طريقة دفع</h1>
    </div>
    <a href="{{ route('dashboard.payment-methods.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.payment-methods.store') }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dbeafe">💳</div>
                <div>
                    <h2>طريقة دفع جديدة</h2>
                    <p>أضف اسم وكود طريقة الدفع.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">الاسم <span class="required-ds">*</span></label>
                        <input type="text" name="name" class="form-control-ds" value="{{ old('name') }}" placeholder="مثال: فودافون كاش" required>
                        @error('name')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الكود <span class="required-ds">*</span></label>
                        <input type="text" name="code" class="form-control-ds" value="{{ old('code') }}" placeholder="مثال: vodafone_cash" required>
                        @error('code')<span class="form-error-ds">{{ $message }}</span>@enderror
                        <small class="form-hint-ds">يُستخدم في النظام (مثل: vodafone_cash, instapay)</small>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="is_active" class="form-control-ds" required>
                            <option value="1" @selected(old('is_active', true))>مفعلة</option>
                            <option value="0" @selected(old('is_active') === '0')>غير مفعلة</option>
                        </select>
                        @error('is_active')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.payment-methods.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection
