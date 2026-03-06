@extends('dashboard.layouts.backend', ['title' => 'الأسئلة'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الأسئلة</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الأسئلة</h1>
        <div class="page-header-actions">
            @can('create_questions')
                <a href="{{ route('dashboard.questions.create') }}" class="btn-add-ds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    إضافة
                </a>
            @endcan
        </div>
    </div>

    <div class="filters-bar-ds fade-up-ds delay-1-ds">
        <div class="filters-right-ds">
            <a href="{{ route('dashboard.questions.index') }}" class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                الكل <span class="badge-count-ds">{{ $count_all }}</span>
            </a>
            <a href="{{ route('dashboard.questions.index', array_filter(['status' => 'yes', 'quize_id' => request('quize_id'), 'type' => request('type')])) }}" class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                مفعل <span class="badge-count-ds">{{ $count_active }}</span>
            </a>
            <a href="{{ route('dashboard.questions.index', array_filter(['status' => 'no', 'quize_id' => request('quize_id'), 'type' => request('type')])) }}" class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                غير مفعل <span class="badge-count-ds">{{ $count_inactive }}</span>
            </a>
            <form action="{{ route('dashboard.questions.index') }}" method="GET" id="questionsFilterForm" style="display:inline-flex;align-items:center;gap:8px;margin-inline-start:10px;flex-wrap:wrap">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <select name="quize_id" class="form-control form-control-sm filter-select-ds js-example-disabled-results" style="width:auto;min-width:160px" onchange="this.form.submit()">
                    <option value="">اختيار الاختبار</option>
                    @foreach($quizes as $quize)
                        <option value="{{ $quize->id }}" @selected(request('quize_id') == $quize->id)>{{ $quize->title }}</option>
                    @endforeach
                </select>
                <select name="type" class="form-control form-control-sm filter-select-ds" style="width:auto;min-width:120px" onchange="this.form.submit()">
                    <option value="">النوع</option>
                    <option value="mcq" @selected(request('type') == 'mcq')>اختياري</option>
                    <option value="text" @selected(request('type') == 'text')>مقالي</option>
                </select>
            </form>
        </div>
        <div class="filters-left-ds">
            <form action="{{ route('dashboard.questions.index') }}" method="GET" class="search-wrap-ds">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                @if(request('quize_id'))<input type="hidden" name="quize_id" value="{{ request('quize_id') }}">@endif
                @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث...">
            </form>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>السؤال</th>
                    <th>الاختبار</th>
                    <th>النوع</th>
                    <th>الإجابة الصحيحة</th>
                    <th>الدرجة</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td style="font-size:.88rem">{{ \Illuminate\Support\Str::limit($item->question, 60) }}</td>
                        <td style="font-size:.85rem">{{ $item->quize->title ?? '—' }}</td>
                        <td>
                            @if($item->type == 'mcq')
                                <span class="status-badge-ds" style="background:#eff6ff;color:var(--blue)">اختياري</span>
                            @else
                                <span class="status-badge-ds" style="background:#f1f5f9;color:#64748b">مقالي</span>
                            @endif
                        </td>
                        <td style="font-size:.82rem">
                            @if($item->type == 'mcq')
                                @foreach($item->answers as $index => $answer)
                                    <div>{{ $index + 1 }} - {{ \Illuminate\Support\Str::limit($answer['answer'] ?? '', 25) }}
                                        @if($answer['is_correct'] ?? false)<span class="status-badge-ds enabled-ds" style="font-size:.7rem">✔</span>@endif
                                    </div>
                                @endforeach
                            @else
                                {{ \Illuminate\Support\Str::limit($item->correct_answer, 30) }}
                            @endif
                        </td>
                        <td>{{ $item->grade }}</td>
                        <td>
                            @if($item->status)
                                <span class="status-badge-ds enabled-ds">مفعل</span>
                            @else
                                <span class="status-badge-ds disabled-ds">غير مفعل</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                @can('update_questions')
                                    <a href="{{ route('dashboard.questions.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endcan
                                @can('delete_questions')
                                    <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد أسئلة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($items->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">{{ $items->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @foreach($items as $item)
        @can('delete_questions')
            @include('dashboard.questions.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush

@push('scripts')
<script>
$(function() {
    var $el = $(".js-example-disabled-results");
    if ($el.length && typeof $el.select2 === 'function') $el.select2();
});
</script>
@endpush