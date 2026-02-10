@extends('dashboard.layouts.backend', ['title' => 'تعديل معلم'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">المعلمين</div>/
                <div class="large"> عرض معلم</div> /
                <div class="large"> {{ $item->fullname }}</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.teachers.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الاسم الاول</span>
                        <div class="box-input">
                            <input type="text" name="f_name" disabled value="{{ $item->f_name }}" id="">
                        </div>

                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الاسم الاخير</span>
                        <div class="box-input">
                            <input type="text" name="l_name" disabled value="{{ $item->l_name }}" id="">
                        </div>

                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>البريد الالكتروني</span>
                        <div class="box-input">
                            <input type="email" disabled name="email" value="{{ $item->email }}" id="">
                        </div>
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الهاتف</span>
                        <div class="box-input">
                            <input type="text" disabled name="phone" value="{{ $item->phone }}" id="">
                        </div>
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="tax" disabled class="form-select select-setting">
                        <option value="1" @selected($item->status == 1)>مفعل</option>
                        <option value="0" @selected($item->status == 0)>غير مفعل</option>
                    </select>

                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الصلاحيه</label>

                    <select name="role" disabled id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected($item->roles->first()?->name == $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <img style="width: 70px; height:70px" src="{{ display_file($item->image) }}" alt=""
                        srcset="">
                </div>
                <div class="col-12 ">
                    <label class="special-input">
                        <span>نبذه مختصره</span>
                    </label>
                    <textarea name="more_information" disabled id="" class="form-control" cols="150" rows="10">{{ $item->more_information }}</textarea>
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection
