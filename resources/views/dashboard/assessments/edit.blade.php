@extends('dashboard.layouts.backend', ['title' => 'تعديل تقييم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.assessments.index') }}">التقييمات</a>
        <span class="sep">/</span>
        <span class="current">تعديل تقييم</span>
    </div>
    <div class="page-header-ds fade-up-ds"><h1>تعديل تقييم</h1></div>
    <a href="{{ route('dashboard.assessments.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>

    <form action="{{ route('dashboard.assessments.update', $item->id) }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        @include('dashboard.assessments.form', ['item' => $item])
    </form>

    <form action="{{ route('dashboard.assessments.sync-questions', $item->id) }}" method="post" class="fade-up-ds delay-2-ds" style="margin-top:20px">
        @csrf
        @method('PUT')
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dbeafe">📚</div>
                <div><h2>مزامنة أسئلة التقييم</h2><p>ترتيب الدرجات والأسئلة من بنك الأسئلة.</p></div>
            </div>
            <div class="form-card-body-ds">
                <div id="questionsRows">
                    @forelse($item->questions as $qIndex => $q)
                    <div class="form-grid-ds question-row" style="margin-bottom:12px;border-bottom:1px dashed #e2e8f0;padding-bottom:8px">
                        <div class="form-group-ds">
                            <label class="form-label-ds">السؤال</label>
                            <select class="form-control-ds" name="questions[{{ $qIndex }}][question_id]">
                                @foreach($allQuestions as $one)
                                    <option value="{{ $one->id }}" @selected($q->id == $one->id)>{{ \Illuminate\Support\Str::limit($one->question_text, 90) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الدرجة</label>
                            <input type="number" min="1" class="form-control-ds" name="questions[{{ $qIndex }}][mark]" value="{{ $q->pivot->mark ?? $q->default_mark }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الترتيب</label>
                            <input type="number" min="1" class="form-control-ds" name="questions[{{ $qIndex }}][order]" value="{{ $q->pivot->order ?? ($qIndex + 1) }}">
                        </div>
                    </div>
                    @empty
                        <div class="status-badge-ds">لا توجد أسئلة مرتبطة حاليًا</div>
                    @endforelse
                </div>

                <button type="button" class="btn-ds btn-secondary-ds" id="addQuestionRow">إضافة صف سؤال</button>

                <div class="form-divider-ds">اختيار عشوائي (اختياري)</div>
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">تفعيل العشوائي</label>
                        <select class="form-control-ds" id="randomEnabled">
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                        <input type="hidden" name="random[enabled]" id="randomEnabledHidden" value="0">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">عدد الأسئلة</label>
                        <input type="number" min="1" class="form-control-ds random-field" name="random[count]" disabled>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">الصعوبة</label>
                        <select class="form-control-ds random-field" name="random[difficulty]" disabled>
                            <option value="">أي مستوى</option>
                            <option value="easy">easy</option>
                            <option value="medium">medium</option>
                            <option value="hard">hard</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ مزامنة الأسئلة</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var rowsWrap = document.getElementById('questionsRows');
    var addBtn = document.getElementById('addQuestionRow');
    var randomEnabled = document.getElementById('randomEnabled');
    var randomEnabledHidden = document.getElementById('randomEnabledHidden');
    var randomFields = document.querySelectorAll('.random-field');
    var allOptions = `{!! addslashes(implode('', $allQuestions->map(fn($one) => '<option value="'.$one->id.'">'.e(\Illuminate\Support\Str::limit($one->question_text, 90)).'</option>')->toArray())) !!}`;

    function toggleRandom() {
        var on = randomEnabled.value === '1';
        randomEnabledHidden.value = on ? '1' : '0';
        randomFields.forEach(function (el) { el.disabled = !on; });
    }
    randomEnabled.addEventListener('change', toggleRandom);
    toggleRandom();

    addBtn.addEventListener('click', function () {
        var idx = rowsWrap.querySelectorAll('.question-row').length;
        var div = document.createElement('div');
        div.className = 'form-grid-ds question-row';
        div.style = 'margin-bottom:12px;border-bottom:1px dashed #e2e8f0;padding-bottom:8px';
        div.innerHTML = '<div class="form-group-ds"><label class="form-label-ds">السؤال</label><select class="form-control-ds" name="questions['+idx+'][question_id]">'+allOptions+'</select></div><div class="form-group-ds"><label class="form-label-ds">الدرجة</label><input type="number" min="1" class="form-control-ds" name="questions['+idx+'][mark]"></div><div class="form-group-ds"><label class="form-label-ds">الترتيب</label><input type="number" min="1" class="form-control-ds" name="questions['+idx+'][order]" value="'+(idx+1)+'"></div>';
        rowsWrap.appendChild(div);
    });
})();
</script>
@endpush
