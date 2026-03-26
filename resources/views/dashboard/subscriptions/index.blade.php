@extends('dashboard.layouts.backend', ['title' => 'الاشتراكات'])

@section('contant')
    <div class="dash-page subscriptions-page">
        <div class="page-breadcrumb fade-up-ds">
            <a href="{{ route('dashboard.home') }}">الرئيسية</a>
            <span class="sep">/</span>
            <span class="current">الاشتراكات</span>
        </div>

        <div class="page-header-ds fade-up-ds">
            <h1>الاشتراكات</h1>
            <div class="page-header-actions">
                @can('create_subscriptions')
                    <a href="{{ route('dashboard.subscriptions.create') }}" class="btn-add-ds">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        إضافة
                    </a>
                @endcan
            </div>
        </div>

        <div class="filters-bar-ds fade-up-ds delay-1-ds">
            <div class="filters-right-ds">
                <a href="{{ route('dashboard.subscriptions.index') }}"
                    class="filter-badge-ds {{ !request('status') ? 'active-ds' : '' }}">
                    الكل <span class="badge-count-ds">{{ $count_all }}</span>
                </a>
                <a href="{{ route('dashboard.subscriptions.index', array_filter(['status' => 'yes', 'student_id' => request('student_id'), 'subject_id' => request('subject_id'), 'payment_status' => request('payment_status'), 'payment_method' => request('payment_method'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'search' => request('search')])) }}"
                    class="filter-badge-ds enabled-ds {{ request('status') === 'yes' ? 'active-ds' : '' }}">
                    مفعلين <span class="badge-count-ds">{{ $count_active }}</span>
                </a>
                <a href="{{ route('dashboard.subscriptions.index', array_filter(['status' => 'no', 'student_id' => request('student_id'), 'subject_id' => request('subject_id'), 'payment_status' => request('payment_status'), 'payment_method' => request('payment_method'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'search' => request('search')])) }}"
                    class="filter-badge-ds disabled-ds {{ request('status') === 'no' ? 'active-ds' : '' }}">
                    غير مفعلين <span class="badge-count-ds">{{ $count_inactive }}</span>
                </a>
                @if ($students->count() > 0)
                    <select id="filter_student_id" class="form-control form-control-sm filter-select-ds"
                        style="width:auto;min-width:160px;margin-inline-start:10px" onchange="filterSubscriptions()">
                        <option value="">جميع الطلاب</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>
                                {{ $student->full_name ?? ($student->fullname ?? $student->email) }}</option>
                        @endforeach
                    </select>
                @endif
                @if ($subjects->count() > 0)
                    <select id="filter_subject_id" class="form-control form-control-sm filter-select-ds"
                        style="width:auto;min-width:140px;margin-inline-start:6px" onchange="filterSubscriptions()">
                        <option value="">جميع المواد</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(request('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                @endif
                <select id="filter_payment_status" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:140px;margin-inline-start:6px" onchange="filterSubscriptions()">
                    <option value="">كل حالات الدفع</option>
                    <option value="paid" @selected(request('payment_status') === 'paid')>مدفوع</option>
                    <option value="pending" @selected(request('payment_status') === 'pending')>معلق</option>
                    <option value="rejected" @selected(request('payment_status') === 'rejected')>مرفوض</option>
                </select>
                @if (($paymentMethods ?? collect())->count() > 0)
                    <select id="filter_payment_method" class="form-control form-control-sm filter-select-ds"
                        style="width:auto;min-width:140px;margin-inline-start:6px" onchange="filterSubscriptions()">
                        <option value="">كل طرق الدفع</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method }}" @selected(request('payment_method') == $method)>{{ $method }}</option>
                        @endforeach
                    </select>
                @endif
                <input type="date" id="filter_from_date" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:130px;margin-inline-start:6px" value="{{ request('from_date') }}"
                    onchange="filterSubscriptions()">
                <input type="date" id="filter_to_date" class="form-control form-control-sm filter-select-ds"
                    style="width:auto;min-width:130px;margin-inline-start:6px" value="{{ request('to_date') }}"
                    onchange="filterSubscriptions()">
                <a href="{{ route('dashboard.subscriptions.index') }}" class="filter-badge-ds"
                    style="margin-inline-start:6px;text-decoration:none">إعادة ضبط</a>
            </div>
            <div class="filters-left-ds">
                <form action="{{ route('dashboard.subscriptions.index') }}" method="get" class="search-wrap-ds">
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if (request('student_id'))
                        <input type="hidden" name="student_id" value="{{ request('student_id') }}">
                    @endif
                    @if (request('subject_id'))
                        <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                    @endif
                    @if (request('payment_status'))
                        <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
                    @endif
                    @if (request('payment_method'))
                        <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
                    @endif
                    @if (request('from_date'))
                        <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                    @endif
                    @if (request('to_date'))
                        <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="بحث...">
                </form>
            </div>
        </div>
        <div class="fade-up-ds delay-2-ds"
            style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:10px;margin-bottom:12px">
            <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:12px;padding:10px 12px">
                <div style="font-size:.76rem;color:#065f46">إجمالي المدفوع (حسب الفلتر)</div>
                <div style="font-size:1.05rem;font-weight:800;color:#047857">{{ number_format($paidAmount ?? 0, 2) }}</div>
            </div>
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:10px 12px">
                <div style="font-size:.76rem;color:#1e40af">عدد المدفوعات المؤكدة</div>
                <div style="font-size:1.05rem;font-weight:800;color:#1d4ed8">{{ $paidCount ?? 0 }}</div>
            </div>
            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:10px 12px">
                <div style="font-size:.76rem;color:#9a3412">عدد المعلقات</div>
                <div style="font-size:1.05rem;font-weight:800;color:#c2410c">{{ $pendingCount ?? 0 }}</div>
            </div>
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:10px 12px">
                <div style="font-size:.76rem;color:#991b1b">عدد المرفوضة</div>
                <div style="font-size:1.05rem;font-weight:800;color:#dc2626">{{ $rejectedCount ?? 0 }}</div>
            </div>
        </div>

        <div class="table-wrap-ds fade-up-ds delay-2-ds">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>المادة</th>
                        <th>المدرس</th>
                        <th>طريقة الدفع</th>
                        <th>حالة الدفع</th>
                        <th>إثبات الدفع</th>
                        <th>المبلغ</th>
                        <th>نوع الاشتراك</th>
                        <th>الفترة</th>
                        <th>الحالة</th>
                        <th>تاريخ الاشتراك</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td class="td-num-ds">{{ $loop->iteration }}</td>
                            <td><span
                                    style="font-weight:800">{{ $item->user->full_name ?? ($item->user->fullname ?? '—') }}</span>
                            </td>
                            <td style="font-size:.9rem">{{ $item->subject->name ?? '—' }}</td>
                            <td style="font-size:.85rem">{{ $item->subject?->teacher?->full_name ?? '—' }}</td>
                            <td style="font-size:.85rem">{{ $item->payment_method ?? '—' }}</td>
                            <td>
                                @if ($item->payment_status === 'paid')
                                    <span class="status-badge-ds enabled-ds">مدفوع</span>
                                @elseif($item->payment_status === 'rejected')
                                    <span class="status-badge-ds disabled-ds"
                                        style="background:#fef2f2;color:#dc2626">مرفوض</span>
                                @else
                                    <span class="status-badge-ds" style="background:#fff7ed;color:#c2410c">معلق</span>
                                @endif
                            </td>
                            <td>
                                @if($item->payment_screenshot)
                                    <a href="{{ display_file($item->payment_screenshot) }}" target="_blank" rel="noopener"
                                        title="عرض صورة التحويل" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none">
                                        <img src="{{ display_file($item->payment_screenshot) }}" alt="receipt"
                                            style="width:34px;height:34px;border-radius:8px;object-fit:cover;border:1px solid #e5e7eb">
                                        <span style="font-size:.8rem;font-weight:700;color:#2563eb">عرض</span>
                                    </a>
                                @else
                                    <span style="font-size:.8rem;color:var(--muted)">لا يوجد</span>
                                @endif
                            </td>
                            <td style="font-weight:700">
                                {{ number_format((float) ($item->amount_paid ?? ($item->subject?->price ?? 0)), 2) }}</td>
                            <td style="font-size:.85rem">
                                @if ($item->period_type === 'month')
                                    شهري
                                @else
                                    ترم
                                @endif
                            </td>
                            <td style="font-size:.85rem;color:var(--muted)">
                                @if ($item->period_type === 'term')
                                    @if ($item->term_number)
                                        ترم {{ $item->term_number }}
                                    @else
                                        —
                                    @endif
                                @else
                                    @if ($item->start_date && $item->end_date)
                                        من {{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }} إلى
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}
                                    @else
                                        —
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($item->status)
                                    <span class="status-badge-ds enabled-ds">مفعل</span>
                                @else
                                    <span class="status-badge-ds disabled-ds">غير مفعل</span>
                                @endif
                            </td>
                            <td style="font-size:.85rem">{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="actions-cell-ds">
                                    @can('update_subscriptions')
                                        <a href="{{ route('dashboard.subscriptions.edit', $item->id) }}"
                                            class="action-btn-ds edit-ds" title="تعديل">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>
                                    @endcan
                                    @can('delete_subscriptions')
                                        <button type="button" class="action-btn-ds delete-ds" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}" title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                            </svg>
                                        </button>
                                    @endcan
                                    @can('update_subscriptions')
                                        @if ($item->payment_status === 'pending')
                                            <form action="{{ route('dashboard.subscriptions.approve', $item) }}" method="post"
                                                style="display:inline-block">
                                                @csrf
                                                <button type="submit" class="action-btn-ds"
                                                    style="background:#ecfdf5;color:#047857;border-color:#bbf7d0"
                                                    title="تأكيد الدفع">✓</button>
                                            </form>
                                            <form action="{{ route('dashboard.subscriptions.reject', $item) }}" method="post"
                                                style="display:inline-block" onsubmit="return confirm('تأكيد رفض الدفع؟')">
                                                @csrf
                                                <button type="submit" class="action-btn-ds"
                                                    style="background:#fef2f2;color:#dc2626;border-color:#fecaca"
                                                    title="رفض الدفع">✕</button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" style="text-align:center;padding:3rem;color:var(--muted);font-weight:600">
                                لا توجد اشتراكات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($items->hasPages())
                <div style="padding:1rem 1.5rem;border-top:1px solid var(--border)">
                    {{ $items->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection

@push('modals')
    @foreach ($items as $item)
        @can('delete_subscriptions')
            @include('dashboard.subscriptions.delete-model', ['item' => $item])
        @endcan
    @endforeach
@endpush

@push('scripts')
    <script>
        function filterSubscriptions() {
            var studentId = document.getElementById('filter_student_id') ? document.getElementById('filter_student_id')
                .value : '';
            var subjectId = document.getElementById('filter_subject_id') ? document.getElementById('filter_subject_id')
                .value : '';
            var paymentStatus = document.getElementById('filter_payment_status') ? document.getElementById(
                'filter_payment_status').value : '';
            var paymentMethod = document.getElementById('filter_payment_method') ? document.getElementById(
                'filter_payment_method').value : '';
            var fromDate = document.getElementById('filter_from_date') ? document.getElementById('filter_from_date')
                .value : '';
            var toDate = document.getElementById('filter_to_date') ? document.getElementById('filter_to_date')
                .value : '';
            var url = new URL(window.location.href);
            if (studentId) url.searchParams.set('student_id', studentId);
            else url.searchParams.delete('student_id');
            if (subjectId) url.searchParams.set('subject_id', subjectId);
            else url.searchParams.delete('subject_id');
            if (paymentStatus) url.searchParams.set('payment_status', paymentStatus);
            else url.searchParams.delete('payment_status');
            if (paymentMethod) url.searchParams.set('payment_method', paymentMethod);
            else url.searchParams.delete('payment_method');
            if (fromDate) url.searchParams.set('from_date', fromDate);
            else url.searchParams.delete('from_date');
            if (toDate) url.searchParams.set('to_date', toDate);
            else url.searchParams.delete('to_date');
            window.location.href = url.toString();
        }
    </script>
@endpush

@section('css')
    <style>
        .subscriptions-page .filters-bar-ds {
            gap: 10px;
        }

        .subscriptions-page .filters-right-ds {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .subscriptions-page .filter-select-ds {
            max-width: 180px;
        }

        .subscriptions-page .filters-right-ds input[type="date"] {
            max-width: 150px;
        }

        .subscriptions-page .table-wrap-ds {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .subscriptions-page .table-wrap-ds table {
            min-width: 1180px !important;
            width: max-content;
        }

        .subscriptions-page .table-wrap-ds table th,
        .subscriptions-page .table-wrap-ds table td {
            white-space: nowrap;
        }

        .subscriptions-page .actions-cell-ds {
            white-space: nowrap;
        }

        @media (max-width: 1366px) {
            .subscriptions-page .filters-bar-ds {
                flex-direction: column;
                align-items: stretch;
            }

            .subscriptions-page .filters-right-ds {
                display: grid;
                grid-template-columns: repeat(4, minmax(120px, 1fr));
                gap: 8px;
            }

            .subscriptions-page .filters-right-ds .filter-badge-ds,
            .subscriptions-page .filters-right-ds .filter-select-ds,
            .subscriptions-page .filters-right-ds input[type="date"] {
                width: 100% !important;
                max-width: unset;
                margin-inline-start: 0 !important;
            }

            .subscriptions-page .filters-left-ds,
            .subscriptions-page .filters-left-ds .search-wrap-ds {
                width: 100%;
            }
        }

        @media (max-width: 992px) {
            .subscriptions-page .filters-right-ds {
                grid-template-columns: repeat(2, minmax(120px, 1fr));
            }

            .subscriptions-page .table-wrap-ds table th:nth-child(4),
            .subscriptions-page .table-wrap-ds table td:nth-child(4),
            .subscriptions-page .table-wrap-ds table th:nth-child(9),
            .subscriptions-page .table-wrap-ds table td:nth-child(9),
            .subscriptions-page .table-wrap-ds table th:nth-child(10),
            .subscriptions-page .table-wrap-ds table td:nth-child(10) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .subscriptions-page .page-header-ds h1 {
                font-size: 1.4rem;
            }

            .subscriptions-page .filters-right-ds {
                grid-template-columns: 1fr;
            }

            .subscriptions-page .filters-right-ds .filter-badge-ds,
            .subscriptions-page .filters-right-ds .filter-select-ds,
            .subscriptions-page .filters-right-ds input[type="date"] {
                width: 100% !important;
                min-width: 0 !important;
            }

            .subscriptions-page .fade-up-ds.delay-2-ds[style*="display:grid"] {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        @media (max-width: 420px) {
            .subscriptions-page .filters-right-ds {
                grid-template-columns: 1fr;
            }

            .subscriptions-page .fade-up-ds.delay-2-ds[style*="display:grid"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
