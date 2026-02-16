@extends('dashboard.layouts.backend', ['title' => 'الاسئله'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الاسئله</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_questions')
                        <a href="{{ route('dashboard.questions.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.questions.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.questions.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.questions.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                </div>


                <form action="{{ route('dashboard.questions.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- فلتر القسم -->
                        <div class="col-3">
                            <select name="quize_id" class="js-example-disabled-results form-select">
                                <option value="">اختيار الاختبار</option>
                                @foreach ($quizes as $quize)
                                    <option value="{{ $quize->id }}"
                                        {{ request('quize_id') == $quize->id ? 'selected' : '' }}>
                                        {{ $quize->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="type" id="" class="form-control">
                                <option value="">اختيار النوع</option>
                                <option value="mcq" @selected(request('type') == 'mcq')>اخيارى</option>
                                <option value="text" @selected(request('type') == 'text')>مقالى</option>
                            </select>
                        </div>
                        <!-- فلتر الحالة -->
                        <div class="col-3">
                            <select name="status" class="form-select">
                                <option value="">اختيار الحالة</option>
                                <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>مفعل</option>
                                <option value="no" {{ request('status') == 'no' ? 'selected' : '' }}>غير مفعل
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <div>
                                <input class="form-control" type="search" id="" value="{{ request('search') }}"
                                    name="search" placeholder="@lang('Search')" />
                            </div>
                        </div>
                        <!-- زر البحث -->
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary">تصفية</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>السؤال</th>
                        <th>الاختبار</th>
                        <th>النوع</th>
                        <th>الاجابه الصحيحه</th>
                        <th>الدرجه</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->question }}</td>
                            <td> {{ $item->quize->title }}</td>
                            <td>
                                @if ($item->type == 'mcq')
                                    <span class="badge bg-primary">اختياري</span>
                                @else
                                    <span class="badge bg-secondary">مقالى</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->type == 'mcq')
                                    @foreach ($item->answers as $index => $answer)
                                        <div>
                                            {{ $index + 1 }} - {{ $answer['answer'] }}

                                            @if ($answer['is_correct'])
                                                <span class="badge bg-success">✔ صحيحة</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @elseif ($item->type == 'text')
                                    {{ $item->correct_answer }}
                                @endif

                            </td>
                            <td> {{ $item->grade }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_questions')
                                        <a href="{{ route('dashboard.questions.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_questions')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.questions.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}

    </div>
@endsection
@push('scripts')
    <script>
        var $disabledResults = $(".js-example-disabled-results");
        $disabledResults.select2();
    </script>
@endpush
