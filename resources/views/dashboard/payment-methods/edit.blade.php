@extends('dashboard.layouts.backend', ['title' => 'تعديل طريقة الدفع'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">طرق الدفع</div>/
                <div class="large">تعديل طريقة الدفع</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.payment-methods.index') }}">رجوع <i class="fa-solid fa-arrow-left fs-13px"></i></a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.payment-methods.update', $item) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>الاسم</span>
                        <div class="box-input">
                            <input type="text" name="name" value="{{ old('name', $item->name) }}" required>
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
                            <input type="text" name="code" value="{{ old('code', $item->code) }}" required>
                        </div>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label">الحالة</label>
                    <select name="is_active" class="form-select select-setting" required>
                        <option value="1" @selected(old('is_active', $item->is_active))>مفعلة</option>
                        <option value="0" @selected(old('is_active') === '0' || !$item->is_active)>غير مفعلة</option>
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
