@extends('dashboard.layouts.backend', ['title' => 'تعديل درس'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.lectuers.index') }}">الدروس</a>
        <span class="sep">/</span>
        <span class="current">تعديل درس</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>تعديل درس</h1>
    </div>
    <a href="{{ route('dashboard.lectuers.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.lectuers.update', $item->id) }}" method="post" enctype="multipart/form-data" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#e0e7ff">📚</div>
                <div>
                    <h2>{{ $item->title ?: 'تعديل الدرس' }}</h2>
                    <p>تعديل المرحلة والصف والمادة وبيانات الدرس.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">العنوان</label>
                        <input type="text" name="title" class="form-control-ds" value="{{ old('title', $item->title) }}">
                        @error('title')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المرحلة الدراسية</label>
                        <select name="stage_id" id="stage_id" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}" @selected($item->subject && $item->subject->grade && $item->subject->grade->stage && $item->subject->grade->stage->id == $stage->id)>{{ $stage->name }}</option>
                            @endforeach
                        </select>
                        @error('stage_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الصف الدراسي</label>
                        <select name="grade_id" id="grade_id" class="form-control-ds">
                            @if($item->subject && $item->subject->grade)
                                <option value="{{ $item->subject->grade->id }}">{{ $item->subject->grade->name }}</option>
                            @endif
                        </select>
                        @error('grade_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المادة</label>
                        <select name="subject_id" id="subject_id" class="form-control-ds">
                            @if($item->subject)
                                <option value="{{ $item->subject->id }}">{{ $item->subject->name }}</option>
                            @endif
                        </select>
                        @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">اللينك</label>
                        <input type="url" name="link" class="form-control-ds" value="{{ old('link', $item->link) }}">
                        @error('link')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة</label>
                        <select name="status" class="form-control-ds">
                            <option value="1" @selected($item->status == 1)>مفعل</option>
                            <option value="0" @selected($item->status == 0)>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-divider-ds">الوصف</div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الوصف</label>
                    <textarea name="description" class="form-control-ds" rows="6">{{ old('description', $item->description) }}</textarea>
                    @error('description')<span class="form-error-ds">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.lectuers.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('select[name="stage_id"]').on('change', function() {
        var stage_id = $(this).val();
        if (stage_id) {
            var url = "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stage_id);
            $.ajax({ url: url, type: "GET", dataType: "json", success: function(data) {
                $('select[name="grade_id"]').empty().append("<option value=''>-- اختر --</option>");
                $('select[name="subject_id"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="grade_id"]').append('<option value="' + value + '">' + key + '</option>');
                });
            }});
        } else {
            $('select[name="grade_id"]').empty();
            $('select[name="subject_id"]').empty();
        }
    });
    $('select[name="grade_id"]').on('change', function() {
        var grade_id = $(this).val();
        if (grade_id) {
            var url = "{{ route('dashboard.getsubjects', ':id') }}".replace(':id', grade_id);
            $.ajax({ url: url, type: "GET", dataType: "json", success: function(data) {
                $('select[name="subject_id"]').empty().append("<option value=''>-- اختر --</option>");
                $.each(data, function(key, value) {
                    $('select[name="subject_id"]').append('<option value="' + value + '">' + key + '</option>');
                });
            }});
        } else {
            $('select[name="subject_id"]').empty();
        }
    });
});
</script>
@endpush
