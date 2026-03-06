@extends('dashboard.layouts.backend', ['title' => 'إضافة معلم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.teachers.index') }}">المعلمين</a>
        <span class="sep">/</span>
        <span class="current">إضافة معلم جديد</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>إضافة معلم</h1>
    </div>

    <a href="{{ route('dashboard.teachers.index') }}" class="btn-back-ds fade-up-ds">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        رجوع
    </a>

    <x-alert-component></x-alert-component>

    <form action="{{ route('dashboard.teachers.store') }}" method="post" enctype="multipart/form-data" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#fef3c7">👨‍🏫</div>
                <div>
                    <h2>بيانات المعلم</h2>
                    <p>إدخال بيانات معلم جديد وربط الصلاحية الخاصة به.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">الاسم الأول <span class="required-ds">*</span></label>
                        <input type="text" name="f_name" class="form-control-ds" value="{{ old('f_name') }}" required>
                        @error('f_name')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626;font-weight:600">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الاسم الأخير <span class="required-ds">*</span></label>
                        <input type="text" name="l_name" class="form-control-ds" value="{{ old('l_name') }}" required>
                        @error('l_name')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">البريد الإلكتروني <span class="required-ds">*</span></label>
                        <input type="email" name="email" class="form-control-ds" value="{{ old('email') }}" required>
                        @error('email')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الهاتف</label>
                        <input type="text" name="phone" class="form-control-ds" value="{{ old('phone') }}" style="direction:ltr;text-align:right">
                        @error('phone')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" class="form-control-ds" required>
                            <option value="" @selected(old('status') === null)>-- اختر --</option>
                            <option value="1" @selected(old('status') === '1')>مفعل</option>
                            <option value="0" @selected(old('status') === '0')>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الصلاحية <span class="required-ds">*</span></label>
                        <select name="role" class="form-control-ds" required>
                            <option value="">-- اختر --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role') === $role->name)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">صورة المعلم</label>
                        <label class="file-upload-ds" style="position:relative">
                            <input type="file" name="image" accept="image/*">
                            <div class="file-upload-icon-ds">🖼️</div>
                            <div class="file-upload-text-ds">اسحب الصورة هنا أو <span>تصفح</span></div>
                            <div class="file-upload-hint-ds">PNG, JPG حتى 2MB</div>
                        </label>
                        @error('image')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-divider-ds">نبذة عن المعلم</div>
                <div class="form-group-ds" style="grid-column:1 / -1">
                    <label class="form-label-ds">نبذة مختصرة</label>
                    <textarea name="more_information" class="form-control-ds" rows="4" placeholder="اكتب نبذة تعريفية عن المعلم">{{ old('more_information') }}</textarea>
                    @error('more_information')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                </div>

                <div class="form-divider-ds">بيانات الدخول</div>
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">كلمة المرور <span class="required-ds">*</span></label>
                        <input type="password" name="password" class="form-control-ds" required>
                        @error('password')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تأكيد كلمة المرور <span class="required-ds">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control-ds" required>
                        @error('password_confirmation')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    حفظ المعلم
                </button>
                <a href="{{ route('dashboard.teachers.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection
