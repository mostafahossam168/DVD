<div class="form-card-ds">
    <div class="form-card-header-ds">
        <div class="fch-icon-ds" style="background:#e0e7ff">🧠</div>
        <div><h2>بيانات السؤال</h2><p>السؤال قابل لإعادة الاستخدام في كل التقييمات.</p></div>
    </div>
    <div class="form-card-body-ds">
        <div class="form-grid-ds">
            <div class="form-group-ds">
                <label class="form-label-ds">نص السؤال</label>
                <textarea name="question_text" class="form-control-ds" rows="3">{{ old('question_text', $item->question_text ?? '') }}</textarea>
                @error('question_text')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">النوع</label>
                <select name="type" class="form-control-ds" id="qbType">
                    <option value="mcq" @selected(old('type', $item->type ?? '') === 'mcq')>mcq</option>
                    <option value="true_false" @selected(old('type', $item->type ?? '') === 'true_false')>true_false</option>
                    <option value="text" @selected(old('type', $item->type ?? '') === 'text')>text</option>
                </select>
                @error('type')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الصعوبة</label>
                <select name="difficulty" class="form-control-ds">
                    <option value="easy" @selected(old('difficulty', $item->difficulty ?? 'medium') === 'easy')>easy</option>
                    <option value="medium" @selected(old('difficulty', $item->difficulty ?? 'medium') === 'medium')>medium</option>
                    <option value="hard" @selected(old('difficulty', $item->difficulty ?? 'medium') === 'hard')>hard</option>
                </select>
                @error('difficulty')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الدرجة الافتراضية</label>
                <input type="number" min="1" name="default_mark" class="form-control-ds" value="{{ old('default_mark', $item->default_mark ?? '') }}">
                @error('default_mark')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المرحلة</label>
                <select name="stage_id" id="questionStageSelect" class="form-control-ds">
                    <option value="">اختر المرحلة</option>
                    @foreach(($stages ?? collect()) as $stage)
                        <option value="{{ $stage->id }}" @selected((string) old('stage_id', $item->stage_id ?? '') === (string) $stage->id)>{{ $stage->name }}</option>
                    @endforeach
                </select>
                @error('stage_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الصف</label>
                <select name="grade_id" id="questionGradeSelect" class="form-control-ds">
                    <option value="">اختر الصف</option>
                </select>
                @error('grade_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المادة</label>
                <select name="subject_id" id="questionSubjectSelect" class="form-control-ds">
                    <option value="">اختر المادة</option>
                </select>
                @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            @if(auth()->user()->type === 'admin')
            <div class="form-group-ds">
                <label class="form-label-ds">المعلم</label>
                <select name="teacher_id" class="form-control-ds">
                    <option value="">اختر</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" @selected(old('teacher_id', $item->teacher_id ?? '') == $teacher->id)>{{ $teacher->full_name }}</option>
                    @endforeach
                </select>
                @error('teacher_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            @endif
            <div class="form-group-ds">
                <label class="form-label-ds">الحالة</label>
                <select name="status" class="form-control-ds">
                    <option value="1" @selected((string) old('status', $item->status ?? 1) === '1')>مفعل</option>
                    <option value="0" @selected((string) old('status', $item->status ?? 1) === '0')>غير مفعل</option>
                </select>
                @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
        </div>

        @php
            $oldAnswers = old('answers');
            $editAnswers = isset($item) && is_array($item->answers) ? collect($item->answers)->pluck('answer')->all() : [];
            $answersRows = is_array($oldAnswers) && count($oldAnswers) ? $oldAnswers : (count($editAnswers) ? $editAnswers : ['', '']);
            $correctRadio = old('correct_answer_radio');
            if ($correctRadio === null && isset($item) && is_array($item->answers)) {
                $correctPos = collect($item->answers)->search(fn ($a) => !empty($a['is_correct']));
                $correctRadio = $correctPos !== false ? ($correctPos + 1) : 1;
            }
        @endphp

        <div id="mcqSection">
            <div class="form-divider-ds">اختيارات MCQ</div>
            <div class="form-group-ds">
                <button type="button" class="btn-ds btn-secondary-ds mb-2" id="addMcqOption">إضافة اختيار</button>
                <div id="mcqOptionsWrap">
                    @foreach($answersRows as $idx => $answerValue)
                        <div class="d-flex gap-2 align-items-center mb-2 mcq-row">
                            <span>{{ $idx + 1 }}-</span>
                            <input type="text" name="answers[]" class="form-control-ds" value="{{ $answerValue }}" placeholder="نص الاختيار">
                            <label class="d-flex align-items-center gap-1 mb-0">
                                <input type="radio" name="correct_answer_radio" value="{{ $idx + 1 }}" @checked((int) $correctRadio === ($idx + 1))>
                                <span>الإجابة الصحيحة</span>
                            </label>
                            <button type="button" class="btn-ds btn-danger-ds remove-mcq-row">x</button>
                        </div>
                    @endforeach
                </div>
                @error('answers')<span class="form-error-ds">{{ $message }}</span>@enderror
                @error('correct_answer_radio')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
        </div>

        <div id="nonMcqAnswerSection">
            <div class="form-divider-ds">الإجابة الصحيحة</div>
            <div class="form-group-ds" id="textAnswerGroup">
                <label class="form-label-ds">الإجابة النصية</label>
                <input type="text" id="correctAnswerText" name="correct_answer" class="form-control-ds" value="{{ old('correct_answer', $item->correct_answer ?? '') }}" placeholder="اكتب الإجابة الصحيحة">
            </div>
            <div class="form-group-ds" id="trueFalseGroup">
                <label class="form-label-ds">الإجابة (صح / خطأ)</label>
                <select name="correct_answer" id="correctAnswerTrueFalse" class="form-control-ds">
                    <option value="">اختر</option>
                    <option value="true" @selected(old('correct_answer', $item->correct_answer ?? '') === 'true')>true</option>
                    <option value="false" @selected(old('correct_answer', $item->correct_answer ?? '') === 'false')>false</option>
                </select>
            </div>
            @error('correct_answer')<span class="form-error-ds">{{ $message }}</span>@enderror
        </div>

        <div class="form-divider-ds">تصنيفات جاهزة</div>
        <div class="form-group-ds">
            <select name="category_ids[]" class="form-control-ds js-categories" multiple>
                @php $selectedCategories = old('category_ids', isset($item) ? $item->categories->pluck('id')->all() : []); @endphp
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(in_array($cat->id, $selectedCategories))>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-divider-ds">إضافة تصنيف جديد</div>
        <div id="newCategoriesWrap">
            <div class="d-flex gap-2 mb-2">
                <input type="text" name="categories[]" class="form-control-ds" placeholder="اسم التصنيف">
                <button type="button" class="btn-ds btn-secondary-ds" id="addCategoryRow">+</button>
            </div>
        </div>
    </div>
    <div class="form-card-footer-ds">
        <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
        <a href="{{ route('dashboard.question-bank.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
    </div>
</div>
@php
    $stagesTree = ($stages ?? collect())->map(function ($stage) {
        return [
            'id' => $stage->id,
            'name' => $stage->name,
            'grades' => $stage->grades->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->name,
                    'subjects' => $grade->subjects->map(function ($subject) {
                        return ['id' => $subject->id, 'name' => $subject->name];
                    })->values()->all(),
                ];
            })->values()->all(),
        ];
    })->values()->all();
@endphp
@push('scripts')
<script>
document.getElementById('addCategoryRow')?.addEventListener('click', function () {
    var wrap = document.getElementById('newCategoriesWrap');
    var row = document.createElement('div');
    row.className = 'd-flex gap-2 mb-2';
    row.innerHTML = '<input type="text" name="categories[]" class="form-control-ds" placeholder="اسم التصنيف"><button type="button" class="btn-ds btn-danger-ds remove-row">x</button>';
    wrap.appendChild(row);
});
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.parentElement.remove();
    }
});

(function () {
    var stageSelect = document.getElementById('questionStageSelect');
    var gradeSelect = document.getElementById('questionGradeSelect');
    var subjectSelect = document.getElementById('questionSubjectSelect');
    var typeEl = document.getElementById('qbType');
    var mcqSection = document.getElementById('mcqSection');
    var nonMcqSection = document.getElementById('nonMcqAnswerSection');
    var textAnswerGroup = document.getElementById('textAnswerGroup');
    var trueFalseGroup = document.getElementById('trueFalseGroup');
    var correctAnswerText = document.getElementById('correctAnswerText');
    var correctAnswerTrueFalse = document.getElementById('correctAnswerTrueFalse');
    var mcqWrap = document.getElementById('mcqOptionsWrap');
    var addMcqOptionBtn = document.getElementById('addMcqOption');
    var stagesData = @json($stagesTree);
    var selectedGrade = @json((string) old('grade_id', $item->grade_id ?? ''));
    var selectedSubject = @json((string) old('subject_id', $item->subject_id ?? ''));

    function fillSubjects() {
        if (!stageSelect || !gradeSelect || !subjectSelect) return;
        var stageId = stageSelect.value;
        var gradeId = gradeSelect.value;
        var stage = stagesData.find(function (s) { return String(s.id) === String(stageId); });
        subjectSelect.innerHTML = '<option value="">اختر المادة</option>';
        if (!stage) return;
        var grade = stage.grades.find(function (g) { return String(g.id) === String(gradeId); });
        if (!grade) return;
        grade.subjects.forEach(function (subject) {
            var opt = document.createElement('option');
            opt.value = subject.id;
            opt.textContent = subject.name;
            if (String(selectedSubject) === String(subject.id)) opt.selected = true;
            subjectSelect.appendChild(opt);
        });
    }

    function fillGrades() {
        if (!stageSelect || !gradeSelect || !subjectSelect) return;
        var stageId = stageSelect.value;
        var stage = stagesData.find(function (s) { return String(s.id) === String(stageId); });
        gradeSelect.innerHTML = '<option value="">اختر الصف</option>';
        subjectSelect.innerHTML = '<option value="">اختر المادة</option>';
        if (!stage) return;
        stage.grades.forEach(function (grade) {
            var opt = document.createElement('option');
            opt.value = grade.id;
            opt.textContent = grade.name;
            if (String(selectedGrade) === String(grade.id)) opt.selected = true;
            gradeSelect.appendChild(opt);
        });
        fillSubjects();
    }

    function reindexMcqRows() {
        var rows = mcqWrap.querySelectorAll('.mcq-row');
        rows.forEach(function (row, idx) {
            row.querySelector('span').textContent = (idx + 1) + '-';
            var radio = row.querySelector('input[type="radio"]');
            radio.value = idx + 1;
        });
    }

    addMcqOptionBtn?.addEventListener('click', function () {
        var idx = mcqWrap.querySelectorAll('.mcq-row').length + 1;
        var row = document.createElement('div');
        row.className = 'd-flex gap-2 align-items-center mb-2 mcq-row';
        row.innerHTML = '<span>' + idx + '-</span><input type="text" name="answers[]" class="form-control-ds" placeholder="نص الاختيار"><label class="d-flex align-items-center gap-1 mb-0"><input type="radio" name="correct_answer_radio" value="' + idx + '"><span>الإجابة الصحيحة</span></label><button type="button" class="btn-ds btn-danger-ds remove-mcq-row">x</button>';
        mcqWrap.appendChild(row);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-mcq-row')) {
            var row = e.target.closest('.mcq-row');
            if (row) {
                row.remove();
                reindexMcqRows();
            }
        }
    });

    function toggleByType() {
        var t = typeEl.value;
        if (t === 'mcq') {
            mcqSection.style.display = '';
            nonMcqSection.style.display = 'none';
            if (correctAnswerText) correctAnswerText.disabled = true;
            if (correctAnswerTrueFalse) correctAnswerTrueFalse.disabled = true;
        } else if (t === 'true_false') {
            mcqSection.style.display = 'none';
            nonMcqSection.style.display = '';
            trueFalseGroup.style.display = '';
            textAnswerGroup.style.display = 'none';
            if (correctAnswerText) correctAnswerText.disabled = true;
            if (correctAnswerTrueFalse) correctAnswerTrueFalse.disabled = false;
        } else {
            mcqSection.style.display = 'none';
            nonMcqSection.style.display = '';
            trueFalseGroup.style.display = 'none';
            textAnswerGroup.style.display = '';
            if (correctAnswerText) correctAnswerText.disabled = false;
            if (correctAnswerTrueFalse) correctAnswerTrueFalse.disabled = true;
        }
    }

    typeEl.addEventListener('change', toggleByType);
    toggleByType();

    if (stageSelect && gradeSelect && subjectSelect) {
        stageSelect.addEventListener('change', function () {
            selectedGrade = '';
            selectedSubject = '';
            fillGrades();
        });
        gradeSelect.addEventListener('change', function () {
            selectedSubject = '';
            fillSubjects();
        });
        fillGrades();
    }
})();
</script>
@endpush
