<div class="form-card-ds">
    <div class="form-card-header-ds">
        <div class="fch-icon-ds" style="background:#e0e7ff">📝</div>
        <div><h2>بيانات التقييم</h2><p>امتحان أو كويز أو واجب.</p></div>
    </div>
    <div class="form-card-body-ds">
        <div class="form-grid-ds">
            <div class="form-group-ds">
                <label class="form-label-ds">العنوان</label>
                <input type="text" name="title" class="form-control-ds" value="{{ old('title', $item->title ?? '') }}">
                @error('title')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">النوع</label>
                <select name="type" class="form-control-ds">
                    <option value="exam" @selected(old('type', $item->type ?? '') === 'exam')>exam</option>
                    <option value="quiz" @selected(old('type', $item->type ?? '') === 'quiz')>quiz</option>
                    <option value="assignment" @selected(old('type', $item->type ?? '') === 'assignment')>assignment</option>
                </select>
                @error('type')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المرحلة</label>
                <select name="stage_id" id="assessmentStageSelect" class="form-control-ds">
                    <option value="">اختر المرحلة</option>
                    @foreach(($stages ?? collect()) as $stage)
                        <option value="{{ $stage->id }}" @selected((string) old('stage_id', $item->stage_id ?? '') === (string) $stage->id)>{{ $stage->name }}</option>
                    @endforeach
                </select>
                @error('stage_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الصف</label>
                <select name="grade_id" id="assessmentGradeSelect" class="form-control-ds">
                    <option value="">اختر الصف</option>
                </select>
                @error('grade_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المادة</label>
                <select name="subject_id" id="assessmentSubjectSelect" class="form-control-ds">
                    <option value="">اختر المادة</option>
                </select>
                @error('subject_id')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">البداية</label>
                <input type="datetime-local" name="start_time" class="form-control-ds" value="{{ old('start_time', isset($item) && $item->start_time ? $item->start_time->format('Y-m-d\TH:i') : '') }}">
                @error('start_time')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">النهاية</label>
                <input type="datetime-local" name="end_time" class="form-control-ds" value="{{ old('end_time', isset($item) && $item->end_time ? $item->end_time->format('Y-m-d\TH:i') : '') }}">
                @error('end_time')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">المدة (دقيقة)</label>
                <input type="number" min="1" name="duration" class="form-control-ds" value="{{ old('duration', $item->duration ?? '') }}">
                @error('duration')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
            <div class="form-group-ds">
                <label class="form-label-ds">الحالة</label>
                <select name="status" class="form-control-ds">
                    <option value="1" @selected((string) old('status', $item->status ?? 1) === '1')>مفعل</option>
                    <option value="0" @selected((string) old('status', $item->status ?? 1) === '0')>غير مفعل</option>
                </select>
                @error('status')<span class="form-error-ds">{{ $message }}</span>@enderror
            </div>
        </div>

        @if(($showQuestionSelector ?? false) && isset($allQuestions))
            @php
                $oldRows = old('questions', []);
            @endphp
            <div class="form-divider-ds">اختيار أسئلة التقييم</div>
            <div id="questionsRowsCreate">
                @forelse($oldRows as $qIndex => $row)
                    <div class="form-grid-ds question-row-create" style="margin-bottom:12px;border-bottom:1px dashed #e2e8f0;padding-bottom:8px">
                        <div class="form-group-ds">
                            <label class="form-label-ds">السؤال</label>
                            <select class="form-control-ds" name="questions[{{ $qIndex }}][question_id]">
                                <option value="">اختر سؤال</option>
                                @foreach($allQuestions as $one)
                                    <option value="{{ $one->id }}" @selected(($row['question_id'] ?? null) == $one->id)>{{ \Illuminate\Support\Str::limit($one->question_text, 90) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الدرجة</label>
                            <input type="number" min="1" class="form-control-ds" name="questions[{{ $qIndex }}][mark]" value="{{ $row['mark'] ?? '' }}">
                        </div>
                        <div class="form-group-ds">
                            <label class="form-label-ds">الترتيب</label>
                            <input type="number" min="1" class="form-control-ds" name="questions[{{ $qIndex }}][order]" value="{{ $row['order'] ?? ($qIndex + 1) }}">
                        </div>
                        <div class="form-group-ds" style="align-self:end">
                            <button type="button" class="btn-ds btn-danger-ds remove-question-row-create">حذف الصف</button>
                        </div>
                    </div>
                @empty
                    <div class="status-badge-ds">اختياري: اضف الأسئلة الآن أو عدل التقييم بعد الحفظ</div>
                @endforelse
            </div>
            <button type="button" class="btn-ds btn-secondary-ds" id="addQuestionRowCreate">إضافة صف سؤال</button>
            @error('questions')<span class="form-error-ds">{{ $message }}</span>@enderror

            <div class="form-divider-ds">اختيار عشوائي (اختياري)</div>
            <div class="form-grid-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds">تفعيل العشوائي</label>
                    <select class="form-control-ds" id="randomEnabledCreate">
                        <option value="0" @selected(old('random.enabled', 0) == 0)>لا</option>
                        <option value="1" @selected(old('random.enabled', 0) == 1)>نعم</option>
                    </select>
                    <input type="hidden" name="random[enabled]" id="randomEnabledHiddenCreate" value="{{ old('random.enabled', 0) ? 1 : 0 }}">
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">عدد الأسئلة</label>
                    <input type="number" min="1" class="form-control-ds random-field-create" name="random[count]" value="{{ old('random.count') }}">
                </div>
                <div class="form-group-ds">
                    <label class="form-label-ds">الصعوبة</label>
                    <select class="form-control-ds random-field-create" name="random[difficulty]">
                        <option value="">أي مستوى</option>
                        <option value="easy" @selected(old('random.difficulty') == 'easy')>easy</option>
                        <option value="medium" @selected(old('random.difficulty') == 'medium')>medium</option>
                        <option value="hard" @selected(old('random.difficulty') == 'hard')>hard</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
    <div class="form-card-footer-ds">
        <button type="submit" class="btn-ds btn-success-ds">حفظ</button>
        <a href="{{ route('dashboard.assessments.index') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
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
(function () {
    var stageSelect = document.getElementById('assessmentStageSelect');
    var gradeSelect = document.getElementById('assessmentGradeSelect');
    var subjectSelect = document.getElementById('assessmentSubjectSelect');
    if (!stageSelect || !gradeSelect || !subjectSelect) return;

    var stagesData = @json($stagesTree);
    var selectedGrade = @json((string) old('grade_id', $item->grade_id ?? ''));
    var selectedSubject = @json((string) old('subject_id', $item->subject_id ?? ''));

    function fillSubjects() {
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
})();
</script>
@endpush

@if(($showQuestionSelector ?? false) && isset($allQuestions))
@php
    $questionOptionsHtml = implode('', $allQuestions->map(function ($one) {
        return '<option value="'.$one->id.'">'
            .e(\Illuminate\Support\Str::limit($one->question_text, 90))
            .'</option>';
    })->toArray());
@endphp
@push('scripts')
<script>
(function () {
    var rowsWrap = document.getElementById('questionsRowsCreate');
    var addBtn = document.getElementById('addQuestionRowCreate');
    var randomEnabled = document.getElementById('randomEnabledCreate');
    var randomEnabledHidden = document.getElementById('randomEnabledHiddenCreate');
    var randomFields = document.querySelectorAll('.random-field-create');
    if (!rowsWrap || !addBtn || !randomEnabled || !randomEnabledHidden) return;

    var allOptions = `{!! addslashes($questionOptionsHtml) !!}`;
    var basePlaceholder = '<option value="">اختر سؤال</option>';

    function toggleRandom() {
        var on = randomEnabled.value === '1';
        randomEnabledHidden.value = on ? '1' : '0';
        randomFields.forEach(function (el) { el.disabled = !on; });
    }

    randomEnabled.addEventListener('change', toggleRandom);
    toggleRandom();

    addBtn.addEventListener('click', function () {
        var idx = rowsWrap.querySelectorAll('.question-row-create').length;
        var div = document.createElement('div');
        div.className = 'form-grid-ds question-row-create';
        div.style = 'margin-bottom:12px;border-bottom:1px dashed #e2e8f0;padding-bottom:8px';
        div.innerHTML = '<div class="form-group-ds"><label class="form-label-ds">السؤال</label><select class="form-control-ds" name="questions['+idx+'][question_id]">'+(basePlaceholder + allOptions)+'</select></div><div class="form-group-ds"><label class="form-label-ds">الدرجة</label><input type="number" min="1" class="form-control-ds" name="questions['+idx+'][mark]"></div><div class="form-group-ds"><label class="form-label-ds">الترتيب</label><input type="number" min="1" class="form-control-ds" name="questions['+idx+'][order]" value="'+(idx+1)+'"></div><div class="form-group-ds" style="align-self:end"><button type="button" class="btn-ds btn-danger-ds remove-question-row-create">حذف الصف</button></div>';
        rowsWrap.appendChild(div);
    });

    rowsWrap.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-question-row-create')) {
            var row = e.target.closest('.question-row-create');
            if (row) row.remove();
        }
    });
})();
</script>
@endpush
@endif
