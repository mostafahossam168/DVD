@extends('dashboard.layouts.backend', ['title' => 'تقييمات الكورسات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">تقييمات الكورسات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center gap-2 mt-2">
                @can('create_course_reviews')
                    <a href="{{ route('dashboard.course-reviews.create') }}" class="main-btn"><i class="fas fa-plus"></i> إضافة</a>
                @endcan
                <a href="{{ route('dashboard.course-reviews.index') }}" class="main-btn btn-main-color">الكل: {{ $count_all }}</a>
                <a href="{{ route('dashboard.course-reviews.index', ['status' => 'yes']) }}" class="main-btn btn-sm bg-success">مفعلة: {{ $count_active }}</a>
                <a href="{{ route('dashboard.course-reviews.index', ['status' => 'no']) }}" class="main-btn btn-sm bg-danger">غير مفعلة: {{ $count_inactive }}</a>
            </div>
            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon">
                    <input type="search" value="{{ request('search') }}" name="search" placeholder="@lang('Search')">
                </form>
            </div>
        </div>

        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>المادة</th>
                        <th>التقييم</th>
                        <th>نص التقييم</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->image)
                                        <img src="{{ display_file($item->image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:50%;">
                                    @endif
                                    {{ $item->name }}
                                </div>
                            </td>
                            <td>{{ $item->subject_field ?? $item->subject?->name ?? '-' }}</td>
                            <td><span class="text-warning">★</span> {{ $item->rating }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->review_text, 50) }}</td>
                            <td>
                                @if($item->status)
                                    <span class="badge bg-success">مفعلة</span>
                                @else
                                    <span class="badge bg-danger">غير مفعلة</span>
                                @endif
                            </td>
                            <td>
                                @can('update_course_reviews')
                                    <a href="{{ route('dashboard.course-reviews.edit', $item) }}" class="btn btn-primary btn-sm text-white"><i class="fa-solid fa-pen"></i></a>
                                @endcan
                                @can('delete_course_reviews')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                                @endcan
                                @include('dashboard.course-reviews.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">لا توجد تقييمات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}
    </div>
@endsection
