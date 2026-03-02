@extends('dashboard.layouts.backend', ['title' => 'رسائل تواصل معنا'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">رسائل تواصل معنا</div>
        </div>

        <x-alert-component></x-alert-component>

        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>البريد</th>
                        <th>الرسالة</th>
                        <th>تاريخ الإرسال</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->message, 50) }}</td>
                            <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    <a href="{{ route('dashboard.contacts.show', $item->id) }}"
                                        class="btn btn-info btn-sm text-white">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('dashboard.contacts.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف الرسالة؟');">
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

