@extends('dashboard.layouts.backend', ['title' => 'عرض الصلاحية'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.roles.index') }}">الصلاحيات</a>
        <span class="sep">/</span>
        <span class="current">عرض الصلاحية</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>عرض الصلاحية</h1>
        <div class="page-header-actions">
            <a href="{{ route('dashboard.roles.index') }}" class="btn-back-ds" style="margin-bottom:0">رجوع</a>
        </div>
    </div>
    <div class="form-card-ds fade-up-ds delay-1-ds">
        <div class="form-card-header-ds">
            <div class="fch-icon-ds" style="background:#f1f5f9">🔐</div>
            <div>
                <h2>{{ $role->name }}</h2>
                <p>عرض الصلاحيات الفرعية لهذه الصلاحية.</p>
            </div>
        </div>
        <div class="form-card-body-ds">
            <div class="form-group-ds mb-4">
                <label class="form-label-ds">الاسم</label>
                <div class="form-control-ds" style="background:#f9fafb">{{ $role->name }}</div>
            </div>
            <div class="table-responsive">
                <table class="table-role table table-bordered">
                    @foreach($permissions as $name => $model_permissions)
                        <tr>
                            <th>{{ trans('models.' . $name, [], 'ar') ?: ucfirst($name) }}</th>
                            @foreach($model_permissions as $model_permission)
                                <td>
                                    <div class="toggle">
                                        <label class="switch">
                                            <input type="checkbox" disabled @checked(in_array($model_permission . '_' . $name, $rolePermissions))
                                                value="{{ $model_permission . '_' . $name }}" id="{{ $model_permission . '_' . $name }}">
                                            <span class="slider round"></span>
                                        </label>
                                        <label for="{{ $model_permission . '_' . $name }}" class="title">{{ trans('actions.' . $model_permission, [], 'ar') ?: __($model_permission) }}</label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
