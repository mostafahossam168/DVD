@extends('dashboard.layouts.backend', ['title' => 'إضافة طريقة دفع'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">طرق الدفع</div>/
                <div class="large">إضافة طريقة دفع</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.payment-methods.index') }}">رجوع <i class="fa-solid fa-arrow-left fs-13px"></i></a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.payment-methods.store') }}" method="post">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>الاسم</span>
                        <div class="box-input">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: فودافون كاش" required>
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>الكود</span>
                        <div class="box-input">
                            <input type="text" name="code" value="{{ old('code') }}" placeholder="مثال: vodafone_cash" required>
                        </div>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">يُستخدم في النظام (مثل: vodafone_cash, instapay)</small>
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label">الحالة</label>
                    <select name="is_active" class="form-select select-setting" required>
                        <option value="1" @selected(old('is_active', true))>مفعلة</option>
                        <option value="0" @selected(old('is_active') === '0')>غير مفعلة</option>
                    </select>
                    @error('is_active')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit">
                <a class="main-btn">حفظ</a>
            </button>
        </form>
    </div>
@endsection
