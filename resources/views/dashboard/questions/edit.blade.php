@extends('dashboard.layouts.backend', ['title' => 'تعديل سؤال'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.questions.index') }}">الاسئلة</a>
        <span class="sep">/</span>
        <span class="current">تعديل سؤال</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>تعديل سؤال</h1>
    </div>
    <a href="{{ route('dashboard.questions.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.questions.update', $item->id) }}" method="post" enctype="multipart/form-data" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#e0e7ff">❓</div>
                <div>
                    <h2>{{ Str::limit($item->question, 40) ?: 'تعديل السؤال' }}</h2>
                    <p>تعديل الاختبار، النوع، السؤال والاجابات.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">السؤال</label>
                        <input type="text" name="question" class="form-control-ds" value="{{ old('question', $item->question) }}">
                        @error('question')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الاختبار</label>
                        <select name="quize_id" id="quize_id" class="js-example-disabled-results form-control-ds">
                            <option value="">-- اختر --</option>
                            @foreach ($quizes as $quize)
                                <option value="{{ $quize->id }}" @selected($quize->id == $item->quize_id)>{{ $quize->title }}</option>
                            @endforeach
                        </select>
                        @error('quize_id')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">النوع</label>
                        <select name="type" id="type" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="mcq" @selected($item->type == 'mcq')>اخيارى</option>
                            <option value="text" @selected($item->type == 'text')>مقالى</option>
                        </select>
                        @error('type')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds" id="text_answer">
                        <label class="form-label-ds">الاجابة الصحيحة</label>
                        <input type="text" name="correct_answer" class="form-control-ds" value="{{ old('correct_answer', $item->correct_answer) }}">
                        @error('correct_answer')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الدرجة</label>
                        <input type="number" name="grade" class="form-control-ds" value="{{ old('grade', $item->grade) }}">
                        @error('grade')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الحالة</label>
                        <select name="status" class="form-control-ds">
                            <option value="">-- اختر --</option>
                            <option value="1" @selected($item->status == 1)>مفعل</option>
                            <option value="0" @selected($item->status == 0)>غير مفعل</option>
                        </select>
                        @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-divider-ds">الاجابات (اختيار من متعدد)</div>
                <div class="form-group-ds" id="multiple_chosse">
                    <label class="form-label-ds">الاجابات</label>
                    <button type="button" id="addOption" class="btn-ds btn-success-ds btn-sm mb-3">إضافة اختيار جديد</button>
                    @php
                        $answers = is_array($item->answers) ? $item->answers : json_decode($item->answers, true);
                    @endphp
                    @if(!empty($answers))
                        @foreach($answers as $index => $answer)
                            <div class="d-flex gap-2 align-items-center mb-2 mcq-item flex-wrap">
                                <span>{{ $index + 1 }}-</span>
                                <input type="text" name="answers[]" class="form-control-ds" style="max-width:220px" value="{{ $answer['answer'] ?? '' }}">
                                <label class="d-flex align-items-center gap-1 mb-0">
                                    <input type="radio" name="correct_answer_radio" value="{{ $index + 1 }}" @checked(!empty($answer['is_correct']))>
                                    <span>الاجابة الصحيحة</span>
                                </label>
                            </div>
                        @endforeach
                    @endif
                    @error('answers')<span class="form-error-ds">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
                <a href="{{ route('dashboard.questions.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function() {
    var $el = $(".js-example-disabled-results");
    if ($el.length) $el.select2();
})();
</script>
<script>
document.getElementById('addOption').addEventListener('click', function() {
    var container = document.getElementById('multiple_chosse');
    var index = (container.querySelectorAll('.mcq-item').length || 0) + 1;
    var div = document.createElement('div');
    div.className = 'd-flex gap-2 align-items-center mb-2 mcq-item flex-wrap';
    div.innerHTML = '<span>' + index + '-</span><input type="text" name="answers[]" class="form-control-ds" style="max-width:220px"><label class="d-flex align-items-center gap-1 mb-0"><input type="radio" name="correct_answer_radio" value="' + index + '"><span>الاجابة الصحيحة</span></label>';
    container.appendChild(div);
});
var inputType = document.getElementById('type');
var sectionText = document.getElementById('text_answer');
var sectionMultile = document.getElementById('multiple_chosse');
function toggleType() {
    if (!sectionText || !sectionMultile) return;
    if (inputType.value === 'mcq') {
        sectionMultile.removeAttribute('hidden');
        sectionText.setAttribute('hidden', 'hidden');
    } else if (inputType.value === 'text') {
        sectionText.removeAttribute('hidden');
        sectionMultile.setAttribute('hidden', 'hidden');
    } else {
        sectionText.setAttribute('hidden', 'hidden');
        sectionMultile.setAttribute('hidden', 'hidden');
    }
}
if (inputType) inputType.addEventListener('change', toggleType);
toggleType();
</script>
@endpush
