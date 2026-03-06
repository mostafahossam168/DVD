@extends('dashboard.layouts.backend', ['title' => 'رسائل تواصل معنا'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">رسائل تواصل معنا</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>رسائل تواصل معنا</h1>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-1-ds">
        <table>
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
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->name }}</span></td>
                        <td style="font-size:.83rem;direction:ltr;text-align:right">{{ $item->phone ?? '—' }}</td>
                        <td style="color:var(--muted);font-size:.83rem">{{ $item->email ?? '—' }}</td>
                        <td style="font-size:.85rem;max-width:200px">{{ \Illuminate\Support\Str::limit($item->message, 50) }}</td>
                        <td style="color:var(--muted);font-size:.83rem">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <div class="actions-cell-ds">
                                <a href="{{ route('dashboard.contacts.show', $item->id) }}" class="action-btn-ds edit-ds" title="عرض">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <form action="{{ route('dashboard.contacts.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف الرسالة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn-ds delete-ds" title="حذف">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد رسائل</td>
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
