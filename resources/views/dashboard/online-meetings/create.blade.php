@extends('dashboard.layouts.backend', ['title' => 'إضافة محاضرة أونلاين'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.online-meetings.index') }}">المحاضرات الأونلاين</a>
        <span class="sep">/</span>
        <span class="current">إضافة محاضرة أونلاين</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>إضافة محاضرة أونلاين</h1>
    </div>
    <a href="{{ route('dashboard.online-meetings.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>
    <form action="{{ route('dashboard.online-meetings.store') }}" method="POST" class="fade-up-ds delay-1-ds">
        @include('dashboard.online-meetings.form')
    </form>
</div>
@endsection

@push('scripts')
    <script>
        const gradesSelect = document.querySelector('select[name="grade_id"]');
        const subjectsSelect = document.querySelector('select[name="subject_id"]');
        const stageSelect = document.querySelector('select[name="stage_id"]');

        function loadGrades(stageId, selectedGradeId = null) {
            if (!stageId) {
                if (gradesSelect) gradesSelect.innerHTML = '';
                if (subjectsSelect) subjectsSelect.innerHTML = '';
                return;
            }

            let url = "{{ route('dashboard.getgrade', ':id') }}".replace(':id', stageId);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (!gradesSelect) return;
                    gradesSelect.innerHTML = '<option value=\"\">-- اختر --</option>';
                    subjectsSelect.innerHTML = '<option value=\"\">-- اختر --</option>';

                    Object.entries(data).forEach(([name, id]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        if (selectedGradeId && parseInt(selectedGradeId) === parseInt(id)) {
                            option.selected = true;
                        }
                        gradesSelect.appendChild(option);
                    });
                });
        }

        function loadSubjects(gradeId, selectedSubjectId = null) {
            if (!gradeId) {
                if (subjectsSelect) subjectsSelect.innerHTML = '';
                return;
            }

            let url = "{{ route('dashboard.getsubjects', ':id') }}".replace(':id', gradeId);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (!subjectsSelect) return;
                    subjectsSelect.innerHTML = '<option value=\"\">-- اختر --</option>';

                    Object.entries(data).forEach(([name, id]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        if (selectedSubjectId && parseInt(selectedSubjectId) === parseInt(id)) {
                            option.selected = true;
                        }
                        subjectsSelect.appendChild(option);
                    });
                });
        }

        if (stageSelect) {
            stageSelect.addEventListener('change', function() {
                loadGrades(this.value);
            });
        }

        if (gradesSelect) {
            gradesSelect.addEventListener('change', function() {
                loadSubjects(this.value);
            });
        }
    </script>
@endpush

