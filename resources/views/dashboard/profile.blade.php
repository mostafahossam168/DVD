@extends('dashboard.layouts.backend', ['title' => 'الملف الشخصى'])
@section('contant')
    <div class="main-side">
        <form action="{{ route('dashboard.update-profile') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="main-title">
                    <div class="small">
                        لوحة التحكم
                    </div>
                    <div class="large">
                        الملف الشخصى
                    </div>
                </div>
                <div class=" d-flex align-items-center justify-content-center">
                    <button type="submit" class="main-btn btn-main-color">حفظ التعديلات</button>
                </div>
            </div>

            <x-alert-component></x-alert-component>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الاسم الاول </span>
                            <div class="box-input">
                                <input type="text" name="f_name" value="{{ $user->f_name }}" id="">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الاسم الاخير </span>
                            <div class="box-input">
                                <input type="text" name="l_name" value="{{ $user->l_name }}" id="">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span> البريد الالكترونى</span>
                            <div class="box-input">
                                <input type="text" name="email" value="{{ $user->email }}" id="">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الهاتف</span>
                            <div class="box-input">
                                <input type="text" name="phone" value="{{ $user->phone }}" id="">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الباسورد</span>
                            <div class="box-input">
                                <input type="password" name="password" value="" id="">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>تاكيد الباسورد</span>
                            <div class="box-input">
                                <input type="password" name="password_confirmation" value="" id="">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>صوره الملف الشخصى</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="image" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    <img style="width: 70px; height:70px" src="{{ display_file($user->image) }}" alt=""
                        srcset="">
                </div>
            </div>
        </form>
    </div>
@endsection
