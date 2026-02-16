@extends('dashboard.layouts.backend', ['title' => 'اضافة درس'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الدروس</div>/
                <div class="large">اضافة درس جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.lectuers.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.lectuers.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span> العنوان</span>
                        <div class="box-input">
                            <input type="text" name="title" value="{{ old('title') }}" id="">
                        </div>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>


                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        المرحله الدراسيه</label>
                    <select name="stage_id" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('stage_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الصف الدراسي</label>
                    <select name="grade_id" id="tax" class="form-select select-setting">

                    </select>
                    @error('grade_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الماده</label>
                    <select name="subject_id" id="tax" class="form-select select-setting">
                    </select>
                    @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>اللينك</span>
                        <div class="box-input">
                            <input type="url" name="link" value="{{ old('link') }}" id="">
                        </div>
                        @error('link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        <option value="1">مفعل</option>
                        <option value="0">غير مفعل</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 ">
                    <label class="special-input">
                        <span>الوصف</span>
                    </label>
                    <textarea name="description" id="" class="form-control" cols="150" rows="10">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('select[name="stage_id"]').on('change', function() {
            var stage_id = $(this).val();
            if (stage_id) {
                var url = "{{ route('dashboard.getgrade', ':id') }}";
                url = url.replace(':id', stage_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="grade_id"]').empty();
                        $('select[name="subject_id"]').empty();
                        $('select[name="grade_id"]').append(
                            "<option selected disabled>-- اختر --</option>"
                        );

                        $.each(data, function(key, value) {
                            $('select[name="grade_id"]').append(
                                '<option value="' + value + '">' + key + '</option>'
                            );
                        });
                    },
                });
            }
        });
        $('select[name="grade_id"]').on('change', function() {
            var stage_id = $(this).val();
            if (stage_id) {
                var url = "{{ route('dashboard.getsubjects', ':id') }}";
                url = url.replace(':id', stage_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="subject_id"]').empty();
                        $('select[name="subject_id"]').append(
                            "<option selected disabled>-- اختر --</option>"
                        );

                        $.each(data, function(key, value) {
                            $('select[name="subject_id"]').append(
                                '<option value="' + value + '">' + key + '</option>'
                            );
                        });
                    },
                });
            }
        });
    </script>
@endpush
