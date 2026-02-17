@extends('dashboard.layouts.backend', ['title' => 'اضافة اشتراك'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الاشتراكات</div>/
                <div class="large">اضافة اشتراك جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.subscriptions.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.subscriptions.store') }}" method="post">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-label" for="user_id">
                        الطالب</label>
                    <select name="user_id" id="user_id" class="form-select select-setting" required>
                        <option value="">-- اختر الطالب --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('user_id') == $student->id)>
                                {{ $student->fullname }} - {{ $student->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="subject_id">
                        المادة</label>
                    <select name="subject_id" id="subject_id" class="form-select select-setting" required>
                        <option value="">-- اختر المادة --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
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
