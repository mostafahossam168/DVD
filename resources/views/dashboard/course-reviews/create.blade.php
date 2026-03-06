@extends('dashboard.layouts.backend', ['title' => 'إضافة تقييم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.course-reviews.index') }}">تقييمات الكورسات</a>
        <span class="sep">/</span>
        <span class="current">إضافة تقييم</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>إضافة تقييم</h1>
    </div>
    <a href="{{ route('dashboard.course-reviews.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.course-reviews.store') }}" method="post" enctype="multipart/form-data" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#fef3c7">⭐</div>
                <div>
                    <h2>تقييم جديد</h2>
                    <p>اسم صاحب التقييم، المادة، التقييم ونص التقييم.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">اسم صاحب التقييم <span class="required-ds">*</span></label>
                        <input type="text" name="name" class="form-control-ds" value="{{ old('name') }}" required>
                        @error('name')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المادة (مثل: فيزياء، رياضيات)</label>
                        <input type="text" name="subject_field" class="form-control-ds" value="{{ old('subject_field') }}" placeholder="فيزياء">
                        @error('subject_field')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">التقييم (من 0 إلى 5) <span class="required-ds">*</span></label>
                        <input type="number" name="rating" class="form-control-ds" value="{{ old('rating', 5) }}" step="0.1" min="0" max="5" required>
                        @error('rating')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المادة (اختياري)</label>
                        <select name="subject_id" class="form-control-ds">
                            <option value="">-- لا شيء --</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}" @selected(old('subject_id') == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">صورة البروفايل (اختياري)</label>
                        <input type="file" name="image" class="form-control-ds" accept="image/*">
                        @error('image')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" class="form-control-ds" required>
                            <option value="1" @selected(old('status', true))>مفعل</option>
                            <option value="0" @selected(old('status') === '0')>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-divider-ds">نص التقييم</div>
                <div class="form-group-ds">
                    <label class="form-label-ds">نص التقييم <span class="required-ds">*</span></label>
                    <textarea name="review_text" class="form-control-ds" rows="4" required>{{ old('review_text') }}</textarea>
                    @error('review_text')<span class="form-error-ds">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.course-reviews.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection
