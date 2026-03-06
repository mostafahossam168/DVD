@extends('dashboard.layouts.backend', ['title' => 'الاعدادات'])
@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الإعدادات</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>الإعدادات العامة</h1>
    </div>

    <form action="{{ route('dashboard.update-settings') }}" enctype="multipart/form-data" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#e0e7ff">⚙️</div>
                <div>
                    <h2>بيانات الموقع والتواصل</h2>
                    <p>الاسم، الرابط، العنوان ووسائل التواصل.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">إسم الموقع</label>
                        <input type="text" name="website_name" class="form-control-ds" value="{{ setting('website_name') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">رابط الموقع</label>
                        <input type="url" name="website_url" class="form-control-ds" value="{{ setting('website_url') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الرقم الضريبي</label>
                        <input type="number" name="tax_number" class="form-control-ds" value="{{ setting('tax_number') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">العنوان</label>
                        <input type="text" name="address" class="form-control-ds" value="{{ setting('address') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">رقم المبنى</label>
                        <input type="number" name="building_number" class="form-control-ds" value="{{ setting('building_number') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الشارع</label>
                        <input type="text" name="street_number" class="form-control-ds" value="{{ setting('street_number') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">رقم الجوال</label>
                        <input type="tel" name="phone" class="form-control-ds" value="{{ setting('phone') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">فيسبوك</label>
                        <input type="text" name="facebook" class="form-control-ds" value="{{ setting('facebook') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">انستجرام</label>
                        <input type="text" name="instagram" class="form-control-ds" value="{{ setting('instagram') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">رقم الحساب (الايبان)</label>
                        <input type="text" name="iban" class="form-control-ds" value="{{ setting('iban') }}">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تفعيل الضريبة</label>
                        <select name="is_tax" id="tax" class="form-control-ds">
                            <option value="1" @selected(setting('is_tax') == 1)>مفعل</option>
                            <option value="0" @selected(setting('is_tax') == 0)>غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تفعيل ارسال البريد الالكتروني</label>
                        <select name="email_status" id="emailStatus" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">حالة الموقع</label>
                        <select name="website_status" id="siteStatus" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="1" @selected(setting('website_status') == 1)>مفعل</option>
                            <option value="0" @selected(setting('website_status') == 0)>غير مفعل</option>
                        </select>
                    </div>
                </div>
                <div class="form-divider-ds">الشعار والأيقونة</div>
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">صورة الشعار</label>
                        <input type="file" name="logo" id="siteLogo" class="form-control-ds" accept="image/*">
                        @if(setting('logo'))
                            <div class="mt-2"><img src="{{ display_file(setting('logo')) }}" alt="" style="width:70px;height:70px;object-fit:contain;"></div>
                        @endif
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">صورة أيقونة المتصفح</label>
                        <input type="file" name="fav" class="form-control-ds" accept="image/*">
                        @if(setting('fav'))
                            <div class="mt-2"><img src="{{ display_file(setting('fav')) }}" alt="" style="width:70px;height:70px;object-fit:contain;"></div>
                        @endif
                    </div>
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">رسالة تعطيل الموقع</label>
                    <textarea name="maintainance_message" class="form-control-ds" rows="4" placeholder="نعتذر الموقع مغلق للصيانة ...">{{ setting('maintainance_message') }}</textarea>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ التعديلات</button>
            </div>
        </div>
    </form>
</div>
@endsection
