@extends('dashboard.layouts.backend', ['title' => 'إضافة تقييم'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/<div class="small">تقييمات الكورسات</div>/<div class="large">إضافة تقييم</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.course-reviews.index') }}">رجوع <i class="fa-solid fa-arrow-left fs-13px"></i></a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.course-reviews.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>اسم صاحب التقييم</span>
                        <div class="box-input">
                            <input type="text" name="name" value="{{ old('name') }}" required>
                        </div>
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>المادة (مثل: فيزياء، رياضيات)</span>
                        <div class="box-input">
                            <input type="text" name="subject_field" value="{{ old('subject_field') }}" placeholder="فيزياء">
                        </div>
                        @error('subject_field')<span class="text-danger">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>التقييم (من 0 إلى 5)</span>
                        <div class="box-input">
                            <input type="number" name="rating" value="{{ old('rating', 5) }}" step="0.1" min="0" max="5" required>
                        </div>
                        @error('rating')<span class="text-danger">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label">المادة (اختياري)</label>
                    <select name="subject_id" class="form-select select-setting">
                        <option value="">-- لا شيء --</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-12">
                    <label class="special-input">
                        <span>نص التقييم</span>
                        <div class="box-input">
                            <textarea name="review_text" rows="4" required>{{ old('review_text') }}</textarea>
                        </div>
                        @error('review_text')<span class="text-danger">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-input">
                        <span>صورة البروفايل (اختياري)</span>
                        <div class="box-input">
                            <input type="file" name="image" accept="image/*">
                        </div>
                        @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label">الحالة</label>
                    <select name="status" class="form-select select-setting" required>
                        <option value="1" @selected(old('status', true))>مفعل</option>
                        <option value="0" @selected(old('status') === '0')>غير مفعل</option>
                    </select>
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"><a class="main-btn">حفظ</a></button>
        </form>
    </div>
@endsection
