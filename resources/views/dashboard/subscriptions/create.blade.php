@extends('dashboard.layouts.backend', ['title' => 'اضافة اشتراك'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.subscriptions.index') }}">الاشتراكات</a>
        <span class="sep">/</span>
        <span class="current">اضافة اشتراك جديد</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>اضافة اشتراك جديد</h1>
    </div>
    <a href="{{ route('dashboard.subscriptions.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.subscriptions.store') }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dcfce7">📋</div>
                <div>
                    <h2>اشتراك جديد</h2>
                    <p>ربط طالب بمادة مع تحديد نوع الفترة.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">الطالب <span class="required-ds">*</span></label>
                        <select name="user_id" id="user_id" class="form-control-ds" required>
                            <option value="">-- اختر الطالب --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @selected(old('user_id') == $student->id)>{{ $student->fullname }} - {{ $student->email }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المادة <span class="required-ds">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-control-ds" required>
                            <option value="">-- اختر المادة --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة <span class="required-ds">*</span></label>
                        <select name="status" id="status" class="form-control-ds" required>
                            <option value="">-- اختر --</option>
                            <option value="1" @selected(old('status') == '1')>مفعل</option>
                            <option value="0" @selected(old('status') == '0')>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">نوع الاشتراك <span class="required-ds">*</span></label>
                        <select name="period_type" id="period_type" class="form-control-ds" required>
                            <option value="">-- اختر --</option>
                            <option value="term" @selected(old('period_type') == 'term')>بالترم</option>
                            <option value="month" @selected(old('period_type') == 'month')>شهري</option>
                        </select>
                        @error('period_type')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds period-term-fields d-none">
                        <label class="form-label-ds">الترم</label>
                        <select name="term_number" id="term_number" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="1" @selected(old('term_number') == 1)>الترم الأول</option>
                            <option value="2" @selected(old('term_number') == 2)>الترم الثاني</option>
                            <option value="3" @selected(old('term_number') == 3)>الترم الثالث</option>
                        </select>
                        @error('term_number')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds period-month-fields d-none">
                        <label class="form-label-ds">فترة الاشتراك الشهري</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="date" name="start_date" class="form-control-ds flex-grow-1" value="{{ old('start_date') }}" placeholder="تاريخ البداية">
                            <input type="date" name="end_date" class="form-control-ds flex-grow-1" value="{{ old('end_date') }}" placeholder="تاريخ النهاية">
                        </div>
                        @error('start_date')<span class="form-error-ds">{{ $message }}</span>@enderror
                        @error('end_date')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.subscriptions.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function togglePeriodFields() {
    var type = document.getElementById('period_type') && document.getElementById('period_type').value;
    var termFields = document.querySelector('.period-term-fields');
    var monthFields = document.querySelector('.period-month-fields');
    if (!termFields || !monthFields) return;
    termFields.classList.add('d-none');
    monthFields.classList.add('d-none');
    if (type === 'term') termFields.classList.remove('d-none');
    else if (type === 'month') monthFields.classList.remove('d-none');
}
var el = document.getElementById('period_type');
if (el) el.addEventListener('change', togglePeriodFields);
togglePeriodFields();
</script>
@endpush
