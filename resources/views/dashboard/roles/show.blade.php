@extends('dashboard.layouts.backend', [
    'title' => 'عرض الصلاحية',
])
@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الصلاحيات</div>/
                <div class="large">عرض الصلاحية</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.roles.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>





        <div class="row w-100 mx-0 p-3 mb-5 mt-5  bg-white">
            <div class="col-md-12 mb-2">
                <div class="form-group ">
                    <label for="" class="mb-2">الاسم</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="name" disabled value="{{ $role->name }}">
                    </div>
                    @error('name')
                        <p class="text-danger" style="font-size: 12px">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-role table table-bordered">
                    @foreach ($permissions as $name => $model_permissions)
                        <tr>
                            <th> @lang($name) </th>
                            @foreach ($model_permissions as $model_permission)
                                <td>
                                    <div class="toggle">
                                        <label class="switch">
                                            <input type="checkbox" disabled name="permission[]" @checked(in_array($model_permission . '_' . $name, $rolePermissions))
                                                value="{{ $model_permission . '_' . $name }}"
                                                id="{{ $model_permission . '_' . $name }}">
                                            <span class="slider round"></span>
                                        </label>
                                        <label for="{{ $model_permission . '_' . $name }}"
                                            class='title'>{{ __($model_permission) }}</label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
@endsection
