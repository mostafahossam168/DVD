@extends('dashboard.layouts.backend', ['title' => 'اضافة اشتراك مدرس'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.teacher-subscriptions.index') }}">اشتراكات المدرسين</a>
        <span class="sep">/</span>
        <span class="current">اضافة اشتراك جديد</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>اضافة اشتراك مدرس</h1>
    </div>
    <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.teacher-subscriptions.store') }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dcfce7">👨‍🏫</div>
                <div>
                    <h2>اشتراك مدرس جديد</h2>
                    <p>اختر المدرس والخطة والحالة.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">المدرس <span class="required-ds">*</span></label>
                        <select name="user_id" id="user_id" class="form-control-ds" required>
                            <option value="">-- اختر المدرس --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected(old('user_id') == $teacher->id)>{{ $teacher->fullname }} - {{ $teacher->email }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الخطة <span class="required-ds">*</span></label>
                        <select name="plan_id" id="plan_id" class="form-control-ds" required>
                            <option value="">-- اختر الخطة --</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>{{ $plan->name }} - {{ number_format($plan->price, 2) }} ر.س (حد المواد: {{ $plan->subjects_limit }} | حد الطلاب: {{ $plan->students_limit }})</option>
                            @endforeach
                        </select>
                        @error('plan_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" id="status" class="form-control-ds" required>
                            <option value="">-- اختر --</option>
                            <option value="1" @selected(old('status') == '1')>مفعل</option>
                            <option value="0" @selected(old('status') == '0')>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection
