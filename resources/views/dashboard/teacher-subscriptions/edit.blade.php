@extends('dashboard.layouts.backend', ['title' => 'تعديل اشتراك مدرس'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.teacher-subscriptions.index') }}">اشتراكات المدرسين</a>
        <span class="sep">/</span>
        <span class="current">تعديل اشتراك</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>تعديل اشتراك مدرس</h1>
    </div>
    <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.teacher-subscriptions.update', $item->id) }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dcfce7">👨‍🏫</div>
                <div>
                    <h2>تعديل الاشتراك</h2>
                    <p>تعديل المدرس أو الخطة أو الحالة.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">المدرس <span class="required-ds">*</span></label>
                        <select name="user_id" id="user_id" class="form-control-ds" required @disabled(auth()->user()->type === 'teacher' && !auth()->user()->hasRole('admin'))>
                            <option value="">-- اختر المدرس --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected($item->user_id == $teacher->id || old('user_id') == $teacher->id)>{{ $teacher->fullname }} - {{ $teacher->email }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الخطة <span class="required-ds">*</span></label>
                        <select name="plan_id" id="plan_id" class="form-control-ds" required>
                            <option value="">-- اختر الخطة --</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" @selected($item->plan_id == $plan->id || old('plan_id') == $plan->id)>{{ $plan->name }} - {{ number_format($plan->price, 2) }} ر.س (حد المواد: {{ $plan->subjects_limit }} | حد الطلاب: {{ $plan->students_limit }})</option>
                            @endforeach
                        </select>
                        @error('plan_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" id="status" class="form-control-ds" required>
                            <option value="1" @selected($item->status == 1 || old('status') == '1')>مفعل</option>
                            <option value="0" @selected($item->status == 0 || old('status') == '0')>غير مفعل</option>
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
