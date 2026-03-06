@extends('dashboard.layouts.backend', [
    'title' => 'اضافة صلاحيه',
])
@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.roles.index') }}">الصلاحيات</a>
        <span class="sep">/</span>
        <span class="current">إضافة صلاحية</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>إضافة صلاحية</h1>
    </div>
    <a href="{{ route('dashboard.roles.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.roles.store') }}" method="POST" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#f1f5f9">🔐</div>
                <div>
                    <h2>الصلاحيات</h2>
                    <p>إنشاء صلاحية جديدة وتحديد الصلاحيات الفرعية.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-group-ds mb-4">
                    <label class="form-label-ds">الاسم <span class="required-ds">*</span></label>
                    <input type="text" class="form-control-ds" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="form-error-ds" style="font-size:.76rem;color:#dc2626">{{ $message }}</span>@enderror
                </div>
                <div class="form-group-ds mb-3">
                    <label class="form-label-ds" style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="" id="select-all" class="form-control-ds" style="width:18px;height:18px">
                        تحديد الكل
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table-role table table-bordered">
                        @foreach ($permissions as $name => $model_permissions)
                            <tr>
                                <th> {{ trans('models.' . $name, [], 'ar') ?: ucfirst($name) }} </th>
                                @foreach ($model_permissions as $model_permission)
                                    <td>
                                        <div class="toggle">
                                            <label class="switch">
                                                <input type="checkbox" name="permission[]" class='single-select'
                                                    value="{{ $model_permission . '_' . $name }}"
                                                    id="{{ $model_permission . '_' . $name }}">
                                                <span class="slider round"></span>
                                            </label>
                                            <label for="{{ $model_permission . '_' . $name }}"
                                                class='title'>{{ trans('actions.' . $model_permission, [], 'ar') ?: __($model_permission) }}</label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.roles.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#select-all").click(function() {
                $(".single-select").attr('checked', this.checked);
            });
        });
    </script>
@endpush
@endsection
