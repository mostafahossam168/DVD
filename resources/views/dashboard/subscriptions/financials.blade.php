@extends('dashboard.layouts.backend', ['title' => 'مالية المدرسين'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">مالية المدرسين</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>مالية المدرسين (دخل / سحب / صافي)</h1>
    </div>

    <x-alert-component></x-alert-component>

    @can('update_subscriptions')
    <form action="{{ route('dashboard.subscriptions.financials.withdraw') }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds" style="margin-bottom:14px">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#dcfce7">💸</div>
                <div>
                    <h2>تسجيل سحب للمدرس</h2>
                    <p>لتحديث إجمالي المسحوبات وصافي المستحقات.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-grid-ds">
                    <div class="form-group-ds">
                        <label class="form-label-ds">المدرس</label>
                        <select name="teacher_id" class="form-control-ds" required>
                            <option value="">اختر</option>
                            @foreach($allTeachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected(auth()->user()->type === 'teacher' && auth()->id() === $teacher->id)>
                                    {{ $teacher->full_name ?? $teacher->f_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">المبلغ</label>
                        <input type="number" step="0.01" min="0.01" name="amount" class="form-control-ds" required>
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">تاريخ السحب</label>
                        <input type="datetime-local" name="withdrawn_at" class="form-control-ds">
                    </div>
                    <div class="form-group-ds">
                        <label class="form-label-ds">ملاحظة</label>
                        <input type="text" name="note" class="form-control-ds" placeholder="اختياري">
                    </div>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">تسجيل السحب</button>
            </div>
        </div>
    </form>
    @endcan

    <div class="table-wrap-ds fade-up-ds delay-2-ds">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المدرس</th>
                    <th>عدد المواد</th>
                    <th>إجمالي المدفوعات</th>
                    <th>إجمالي المسحوبات</th>
                    <th>الصافي المستحق</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td>{{ $row['teacher']->full_name ?? $row['teacher']->f_name }}</td>
                        <td>{{ $row['subjects_count'] }}</td>
                        <td style="font-weight:800;color:#065f46">{{ number_format($row['income'], 2) }}</td>
                        <td style="font-weight:800;color:#b45309">{{ number_format($row['withdrawn'], 2) }}</td>
                        <td style="font-weight:900;color:{{ $row['net'] >= 0 ? '#1d4ed8' : '#dc2626' }}">{{ number_format($row['net'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem">لا توجد بيانات مالية</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-wrap-ds fade-up-ds delay-3-ds" style="margin-top:16px">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المدرس</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>بواسطة</th>
                    <th>ملاحظة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td class="td-num-ds">{{ $loop->iteration }}</td>
                        <td>{{ $withdrawal->teacher?->full_name ?? '—' }}</td>
                        <td style="font-weight:800">{{ number_format((float) $withdrawal->amount, 2) }}</td>
                        <td>{{ $withdrawal->withdrawn_at?->format('Y-m-d H:i') ?? $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $withdrawal->creator?->full_name ?? '—' }}</td>
                        <td>{{ $withdrawal->note ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem">لا توجد عمليات سحب</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
