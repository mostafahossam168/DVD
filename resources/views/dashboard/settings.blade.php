@extends('dashboard.layouts.backend', ['title' => 'الاعدادات'])
@section('contant')
    <div class="main-side">
        <form action="{{ route('dashboard.update-settings') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="main-title">
                    <div class="small">
                        الإعدادات
                    </div>
                    <div class="large">
                        الإعدادات العامة
                    </div>
                </div>
                <div class=" d-flex align-items-center justify-content-center">
                    <button type="submit" class="main-btn btn-main-color">حفظ التعديلات</button>
                </div>
            </div>


            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>إسم الموقع</span>
                            <div class="box-input">
                                <input type="text" name="website_name" value="{{ setting('website_name') }}"
                                    id="">
                                <img src="img/icons/world.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>رابط الموقع</span>
                            <div class="box-input">
                                <input type="url" name="website_url" value="{{ setting('website_url') }}"
                                    id="">
                                <img src="img/icons/link.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الرقم الضريبي</span>
                            <div class="box-input">
                                <input type="number" name="tax_number" value="{{ setting('tax_number') }}" id="">
                                <img src="img/icons/tax.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>العنوان</span>
                            <div class="box-input">
                                <input type="text" name="address" value="{{ setting('address') }}" id="">
                                <img src="img/icons/location.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>رقم المبنى</span>
                            <div class="box-input">
                                <input type="number" name="building_number" value="{{ setting('building_number') }}"
                                    id="">
                                <img src="img/icons/house.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الشارع</span>
                            <div class="box-input">
                                <input type="text" name="street_number" value="{{ setting('street_number') }}"
                                    id="">
                                <img src="img/icons/location.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>رقم الجوال</span>
                            <div class="box-input">
                                <input type="tel" name="phone" value="{{ setting('phone') }}" id="">
                                <img src="img/icons/call.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>رقم الحساب (الايبان)</span>
                            <div class="box-input">
                                <input type="number" name="iban" value="{{ setting('iban') }}" id="">
                                <img src="img/icons/lock.png" alt="icon" class="icon">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-label" for="tax">تفعيل الضريبة</label>
                        <select name="is_tax" id="tax" class="form-select select-setting">
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-label" for="emailStatus">تفعيل ارسال البريد الالكتروني</label>
                        <select name="" id="emailStatus" class="form-select select-setting">
                            <option value="">-- اختر -- </option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-label" for="siteStatus">حالة الموقع</label>
                        <select name="website_status" id="siteStatus" class="form-select select-setting">
                            <option value="">-- اختر -- </option>
                            <option value="1" @selected(setting('website_status') == 1)>مفعل</option>
                            <option value="0" @selected(setting('website_status') == 0)>غير مفعل</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <hr style="opacity: .1;">
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>صورة الشعار</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="logo" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    <img style="width: 70px; height:70px" src="{{ display_file(setting('logo')) }}" alt=""
                        srcset="">
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>صورة أيقونة المتصفح</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="fav" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    <img style="width: 70px; height:70px" src="{{ display_file(setting('fav')) }}" alt=""
                        srcset="">
                </div>
                <div class="col-12 col-md-8">
                    <label class="special-label" for="siteLogo">رسالة تعطيل الموقع</label>
                    <textarea name="maintainance_message" id="" value="" rows="5" class="form-control"
                        placeholder="نعتذر الموقع مغلق للصيانة ...">{{ setting('maintainance_message') }}</textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
