@extends('dashboard.layouts.backend', ['title' => 'تعديل كورس'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الاسئلة</div>/
                <div class="large">تعديل سؤال </div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.questions.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.questions.update', $item->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>السؤال</span>
                        <div class="box-input">
                            <input type="text" name="question" value="{{ $item->question }}" id="">
                        </div>
                        @error('question')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الاختبار</label>
                    <select name="quize_id" id="tax" class="js-example-disabled-results form-select">
                        <option value="">-- اختر --</option>
                        @foreach ($quizes as $quize)
                            <option value="{{ $quize->id }}" @selected($quize->id == $item->quize_id)>{{ $quize->title }}</option>
                        @endforeach
                    </select>
                    @error('quize_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        النوع</label>
                    <select name="type" id="type" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        {{-- @foreach (collect(\App\Enums\TypeQuestion::cases())->toArray() as $type)
                            <option value="{{ $type }}" @selected($item->type == $type)>
                                {{ $type->name() }}
                            </option>
                        @endforeach --}}
                        <option value="mcq" @selected($item->type == 'mcq')>اخيارى</option>
                        <option value="text" @selected($item->type == 'text')>مقالى</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- / الاجابه الصحيحه لو السؤال نص   --}}
                <div class="col-12 col-md-4 col-lg-3" id="text_answer">
                    <label class="special-input">
                        <span> الاجابه الصحيحه</span>
                        <div class="box-input">
                            <input type="text" name="correct_answer" value="{{ $item->correct_answer }}" id="">
                        </div>
                        @error('correct_answer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                {{-- / الاجابات  لو السؤال اختيار   --}}
                {{-- <div class="row" id="multiple_chosse">
                    <label class="special-input">
                        <span>الاجابات </span>
                    </label>
                    <button type="button" id="addOption" class="btn btn-success btn-sm mt-2 col-5 mb-2">إضافة اختيار
                        جديد</button>
                    <div class="d-flex gap-2 align-content-center mb-2 mcq-item">
                        1-
                        <div class="box-input col-4">
                            <input type="text" name="answers[]" class="form-control">
                        </div>
                        <div class="box-input col-4">
                            <input type="radio" name="correct_answer_radio" value="1">
                            <label>الاجابة الصحيحة</label>
                        </div>
                    </div>
                    @error('answers')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                {{-- / الاجابات لو السؤال اختيار --}}
                <div class="row" id="multiple_chosse">
                    <label class="special-input">
                        <span>الاجابات</span>
                    </label>

                    <button type="button" id="addOption" class="btn btn-success btn-sm mt-2 col-5 mb-2">
                        إضافة اختيار جديد
                    </button>

                    @php
                        $answers = is_array($item->answers) ? $item->answers : json_decode($item->answers, true);
                    @endphp

                    @if (!empty($answers))
                        @foreach ($answers as $index => $answer)
                            <div class="d-flex gap-2 align-content-center mb-2 mcq-item">
                                {{ $index + 1 }}-
                                <div class="box-input col-4">
                                    <input type="text" name="answers[]" class="form-control"
                                        value="{{ $answer['answer'] }}">
                                </div>

                                <div class="box-input col-4">
                                    <input type="radio" name="correct_answer_radio" value="{{ $index + 1 }}"
                                        @checked($answer['is_correct'])>
                                    <label>الاجابة الصحيحة</label>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @error('answers')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span> الدرجه</span>
                        <div class="box-input">
                            <input type="number" name="grade" value="{{ $item->grade }}" id="">
                        </div>
                        @error('grade')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        <option value="1" @selected($item->status == 1)>مفعل</option>
                        <option value="0" @selected($item->status == 0)>غير مفعل</option>
                    </select>
                    @error('status')
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var $disabledResults = $(".js-example-disabled-results");
        $disabledResults.select2();
    </script>
    <script>
        document.getElementById('addOption').addEventListener('click', function() {
            let container = document.getElementById('multiple_chosse');

            // عدد العناصر الحالية (لو من الداتابيز أو مضافة)
            let index = container.querySelectorAll('.mcq-item').length + 1;

            let html = `
        <div class="d-flex gap-2 align-content-center mb-2 mcq-item">
            ${index}-
            <div class="box-input col-4">
                <input type="text" name="answers[]" class="form-control">
            </div>
            <div class="box-input col-4">
                <input type="radio" name="correct_answer_radio" value="${index}">
                <label>الاجابة الصحيحة</label>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', html);
        });

        var inputType = document.getElementById('type');
        var sectionText = document.getElementById('text_answer');
        var sectionMultile = document.getElementById('multiple_chosse');

        function toggleType() {
            if (inputType.value === "mcq") {
                sectionMultile.removeAttribute('hidden');
                sectionText.setAttribute('hidden', true);
            } else if (inputType.value === "text") {
                sectionText.removeAttribute('hidden');
                sectionMultile.setAttribute('hidden', true);
            } else {
                sectionText.setAttribute('hidden', true);
                sectionMultile.setAttribute('hidden', true);
            }
        }
        inputType.addEventListener('change', toggleType);
        // تشغيله عند تحميل الصفحة لو فيه old values
        toggleType();
    </script>
@endpush
