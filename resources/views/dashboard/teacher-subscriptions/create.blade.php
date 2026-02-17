@extends('dashboard.layouts.backend', ['title' => 'اضافة اشتراك مدرس'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">اشتراكات المدرسين</div>/
                <div class="large">اضافة اشتراك جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.teacher-subscriptions.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.teacher-subscriptions.store') }}" method="post">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-label" for="user_id">
                        المدرس</label>
                    <select name="user_id" id="user_id" class="form-select select-setting" required>
                        <option value="">-- اختر المدرس --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('user_id') == $teacher->id)>
                                {{ $teacher->fullname }} - {{ $teacher->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="plan_id">
                        الخطة</label>
                    <select name="plan_id" id="plan_id" class="form-select select-setting" required>
                        <option value="">-- اختر الخطة --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                                {{ $plan->name }} - {{ number_format($plan->price, 2) }} ر.س
                                (حد المواد: {{ $plan->subjects_limit }} | حد الطلاب: {{ $plan->students_limit }})
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="status">
                        الحالة</label>
                    <select name="status" id="status" class="form-select select-setting" required>
                        <option value="">-- اختر --</option>
                        <option value="1" @selected(old('status') == '1')>مفعل</option>
                        <option value="0" @selected(old('status') == '0')>غير مفعل</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection
