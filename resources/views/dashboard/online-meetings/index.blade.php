@extends('dashboard.layouts.backend', ['title' => 'المحاضرات الأونلاين'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">المحاضرات الأونلاين</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    <a href="{{ route('dashboard.online-meetings.create') }}" class="main-btn">
                        <i class="fas fa-plus"></i> اضافة محاضرة أونلاين
                    </a>
                </div>
            </div>
        </div>

        <x-alert-component></x-alert-component>

        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المرحلة</th>
                        <th>الصف</th>
                        <th>المادة</th>
                        <th>الميعاد</th>
                        <th>المدة (دقيقة)</th>
                        <th>الحالة</th>
                        <th>رابط الانضمام</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->topic }}</td>
                            <td>{{ optional(optional($item->subject)->grade->stage)->name }}</td>
                            <td>{{ optional(optional($item->subject)->grade)->name }}</td>
                            <td>{{ optional($item->subject)->name }}</td>
                            <td>{{ optional($item->start_time)->format('Y-m-d H:i') }}</td>
                            <td>{{ $item->duration }}</td>
                            <td>
                                @if ($item->status === 'scheduled')
                                    <span class="badge bg-info">مجدولة</span>
                                @elseif($item->status === 'finished')
                                    <span class="badge bg-secondary">منتهية</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->join_url)
                                    <a href="{{ $item->join_url }}" target="_blank" class="btn btn-sm btn-info">
                                        انضمام
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    <a href="{{ route('dashboard.online-meetings.edit', $item->id) }}"
                                        class="btn btn-primary btn-sm text-white mx-1">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('dashboard.online-meetings.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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

