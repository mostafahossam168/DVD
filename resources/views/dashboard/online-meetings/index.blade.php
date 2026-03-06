@extends('dashboard.layouts.backend', ['title' => 'المحاضرات الأونلاين'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">المحاضرات الأونلاين</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>المحاضرات الأونلاين</h1>
        <div class="page-header-actions">
            <a href="{{ route('dashboard.online-meetings.create') }}" class="btn-add-ds">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                إضافة محاضرة أونلاين
            </a>
        </div>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-1-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>العنوان</th>
                    <th>المرحلة</th>
                    <th>الصف</th>
                    <th>المادة</th>
                    <th>الميعاد</th>
                    <th>المدة</th>
                    <th>الحالة</th>
                    <th>رابط الانضمام</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td><span style="font-weight:800">{{ $item->topic }}</span></td>
                        <td style="font-size:.85rem">{{ optional(optional($item->subject)->grade->stage)->name ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ optional(optional($item->subject)->grade)->name ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ optional($item->subject)->name ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ optional($item->start_time)->format('Y-m-d H:i') ?? '—' }}</td>
                        <td style="font-size:.85rem">{{ $item->duration ?? '—' }}</td>
                        <td>
                            @if($item->status === 'scheduled')
                                <span class="status-badge-ds" style="background:#eff6ff;color:var(--blue)">مجدولة</span>
                            @elseif($item->status === 'finished')
                                <span class="status-badge-ds disabled-ds">منتهية</span>
                            @else
                                <span class="status-badge-ds" style="background:#f1f5f9;color:#64748b">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($item->join_url)
                                <a href="{{ $item->join_url }}" target="_blank" class="action-btn-ds edit-ds" title="انضمام">انضمام</a>
                            @else — @endif
                        </td>
                        <td>
                            <div class="actions-cell-ds">
                                <a href="{{ route('dashboard.online-meetings.edit', $item->id) }}" class="action-btn-ds edit-ds" title="تعديل">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('dashboard.online-meetings.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
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
                        <td colspan="10" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">لا توجد محاضرات</td>
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

