@extends('dashboard.layouts.backend', ['title' => 'اضافة اشتراك'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الاشتراكات</div>/
                <div class="large">اضافة اشتراك جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.subscriptions.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.subscriptions.store') }}" method="post">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="special-label" for="user_id">
                        الطالب</label>
                    <select name="user_id" id="user_id" class="form-select select-setting" required>
                        <option value="">-- اختر الطالب --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('user_id') == $student->id)>
                                {{ $student->fullname }} - {{ $student->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="subject_id">
                        المادة</label>
                    <select name="subject_id" id="subject_id" class="form-select select-setting" required>
                        <option value="">-- اختر المادة --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="special-label" for="status">
                        الحالة</label>
                    <select name="status" id="status" class="form-select select-setting" required>
                        <option value="">-- اختر --</option>
                        <option value="1" @selected(old('status') == '1')>مفعل</option>
                        <option value="0" @selected(old('status') == '0')>غير مفعل</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4">
                    <label class="special-label" for="period_type">
                        نوع الاشتراك</label>
                    <select name="period_type" id="period_type" class="form-select select-setting" required>
                        <option value="">-- اختر --</option>
                        <option value="term" @selected(old('period_type') == 'term')>بالترم</option>
                        <option value="month" @selected(old('period_type') == 'month')>شهري</option>
                    </select>
                    @error('period_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 period-term-fields d-none">
                    <label class="special-label" for="term_number">
                        الترم</label>
                    <select name="term_number" id="term_number" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        <option value="1" @selected(old('term_number') == 1)>الترم الأول</option>
                        <option value="2" @selected(old('term_number') == 2)>الترم الثاني</option>
                        <option value="3" @selected(old('term_number') == 3)>الترم الثالث</option>
                    </select>
                    @error('term_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 period-month-fields d-none">
                    <label class="special-label d-block">
                        فترة الاشتراك الشهري
                    </label>
                    <div class="d-flex gap-2">
                        <div class="flex-fill">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date') }}" placeholder="تاريخ البداية">
                        </div>
                        <div class="flex-fill">
                            <input type="date" name="end_date" class="form-control"
                                value="{{ old('end_date') }}" placeholder="تاريخ النهاية">
                        </div>
                    </div>
                    @error('start_date')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                    @error('end_date')
                        <span class="text-danger d-block">{{ $message }}</span>
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
        function togglePeriodFields() {
            const type = document.getElementById('period_type').value;
            const termFields = document.querySelector('.period-term-fields');
            const monthFields = document.querySelector('.period-month-fields');

            termFields.classList.add('d-none');
            monthFields.classList.add('d-none');

            if (type === 'term') {
                termFields.classList.remove('d-none');
            } else if (type === 'month') {
                monthFields.classList.remove('d-none');
            }
        }

        document.getElementById('period_type').addEventListener('change', togglePeriodFields);
        // initial
        togglePeriodFields();
    </script>
@endpush
